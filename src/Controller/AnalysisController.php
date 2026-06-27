<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Service\FinancialAnalyzerService;
use App\Factory\StatusEvaluatorFactory;

class AnalysisController extends AppController
{

    public function dashboard()
    {
        $year = $this->request->getQuery('year', date('Y'));
        $quarter = $this->request->getQuery('quarter', 1);

        $departmentsTable = $this->fetchTable('Departments');

        $departments = $departmentsTable->find()
            ->contain([
                'Categories.Budgets' => function ($q) use ($year, $quarter) {
                    return $q->where(['Budgets.year' => $year, 'Budgets.quarter' => $quarter]);
                },
                'Categories.Expenses',
                'CustomerMetrics' => function ($q) use ($year, $quarter) {
                    return $q->where(['CustomerMetrics.year' => $year, 'CustomerMetrics.quarter' => $quarter]);
                }
            ])->toArray();

        $results = [];

        // Invocación de Singleton y Factory Method
        $analyzer = FinancialAnalyzerService::getInstance();
        $statusEvaluator = StatusEvaluatorFactory::make('standard');

        foreach ($departments as $dept) {
            $deptData = [
                'name' => $dept->name,
                'total_spent' => 0,
                'weighted_score' => 0,
                'total_budget' => 0,
                'efficiency_index' => 0,
                'status' => 'ESTABLE'
            ];

            $totalCustomers = !empty($dept->customer_metrics) ? $dept->customer_metrics[0]->total_customers : 0;

            foreach ($dept->categories as $cat) {
                foreach ($cat->budgets as $budget) {
                    $deptData['total_budget'] += (float)$budget->amount_limit;
                }

                // 1. Declarar y calcular el gasto específico de ESTA categoría
                $catSpent = 0;
                foreach ($cat->expenses as $expense) {
                    if ($expense->expense_date->format('Y') == $year) {
                        $catSpent += (float)$expense->amount;
                    }
                }

                // 2. Acumular el gasto de la categoría en el total del departamento
                $deptData['total_spent'] += $catSpent;

                // 3. CORRECCIÓN: Multiplicar solo el gasto de la categoría por su peso
                $deptData['weighted_score'] += ($catSpent * $cat->weight);
            }


            // Aplicación de Singleton para el cálculo
            $deptData['efficiency_index'] = $analyzer->calculateEfficiency($deptData['weighted_score'], $totalCustomers);

            // Aplicación de Factory Method para definir el Estado
            $deptData['status'] = $statusEvaluator->getStatus($deptData);

            $results[] = $deptData;
        }

        $this->set(compact('results', 'year', 'quarter'));
    }
}
