<?php
namespace App\Controller;

use App\Controller\AppController;

class AnalysisController extends AppController {
    
    public function dashboard() {

        $year = $this->request->getQuery('year', date('Y'));
        $quarter = $this->request->getQuery('quarter', 1);

        $departmentsTable = $this->fetchTable('Departments');

        $departments = $departmentsTable->find()
            ->contain([
                'Categories.Budgets' => function ($q) use ($year, $quarter) {
                return $q->where(['Budgets.year' => $year, 'Budgets.quarter' => $quarter]);
                },
                'Categories.Expenses' => function ($q) use ($year, $quarter) {
                    // Filtramos gastos por el rango de fechas del trimestre (Opcional pero recomendado)
                    return $q; 
                },
                'CustomerMetrics' => function ($q) use ($year, $quarter) {
                    return $q->where(['CustomerMetrics.year' => $year, 'CustomerMetrics.quarter' => $quarter]);
                }
            ])->toArray();

        $results = [];

        // 2. BUCLE ANIDADO NIVEL 1: Departamentos
        foreach ($departments as $dept) {
            $deptData = [
                'name' => $dept->name,
                'total_spent' => 0,
                'weighted_score' => 0,
                'efficiency_index' => 0,
                'status' => 'ESTABLE'
            ];

            // 3. DINÁMICO: Buscamos la métrica del año y trimestre seleccionado
            $totalCustomers = 0;
            if (!empty($dept->customer_metrics)) {
                $totalCustomers = $dept->customer_metrics[0]->total_customers;
            }

            foreach ($dept->categories as $cat) {
                $catSpent = 0;
                foreach ($cat->expenses as $expense) {
                    // Validación de fecha para que el gasto pertenezca al año seleccionado
                    if ($expense->expense_date->format('Y') == $year) {
                        $catSpent += (float)$expense->amount;
                    }
                }
                
                $deptData['total_spent'] += $catSpent;
                $deptData['weighted_score'] += ($catSpent * $cat->weight);
            }

            // 5. Cálculo del IEO con validación de división por cero
            if ($deptData['weighted_score'] > 0) {
                $deptData['efficiency_index'] = $totalCustomers / ($deptData['weighted_score'] / 100);
            }

            if ($deptData['efficiency_index'] < 1.5) $deptData['status'] = 'CRÍTICO';
            elseif ($deptData['efficiency_index'] > 3) $deptData['status'] = 'EXCELENTE';

            $results[] = $deptData;
        }

        // Pasamos el año y trimestre seleccionado a la vista para que el formulario los mantenga
        $this->set(compact('results', 'year', 'quarter'));
    }
}
