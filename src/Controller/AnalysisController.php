<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Service\FinancialAnalyzerService;
use App\Factory\StatusEvaluatorFactory;
use Cake\Event\EventInterface;

class AnalysisController extends AppController
{
    /**
     * CONFIGURACIÓN DE ACCESOS (SOLUCIÓN B - CAKEPHP 5.x)
     * Se ejecuta antes de cualquier acción del controlador para definir permisos
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Si tu proyecto usa el componente o plugin oficial de Autenticación de CakePHP 5
        if ($this->components()->has('Authentication')) {
            $this->Authentication->addUnauthenticatedActions(['dashboardApi']);
        }
    }

    /**
     * MANTENER WEB TRADICIONAL
     * Renderiza la plantilla HTML clásica de CakePHP (templates/Analysis/dashboard.php)
     */
    public function dashboard()
    {
        // 1. Obtener los parámetros de la solicitud
        $year = $this->request->getQuery('year', date('Y'));
        $quarter = $this->request->getQuery('quarter', 1);

        // 2. Ejecutar la lógica de negocio central unificada
        $results = $this->getDashboardData($year, $quarter);

        // 3. Enviar las variables a la vista tradicional (.php)
        $this->set(compact('results', 'year', 'quarter'));
    }

    /**
     * NUEVO ENDPOINT EXCLUSIVO PARA LA API JSON
     * Consume el Core financiero y retorna datos procesados para React
     */
    public function dashboardApi()
    {
       // 1. Desactivar explícitamente el Renderizador Automático de Vistas HTML de CakePHP
        $this->autoRender = false;

        // 2. CORRECCIÓN DE CORS: Configurar y asignar encabezados globales para React
        $this->setResponse(
            $this->getResponse()
                ->withHeader('Access-Control-Allow-Origin', '*') 
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization, Origin, Accept')
        );

        // Responder inmediatamente a peticiones de control preflight (OPTIONS) con estado 200 (Éxito)
        if ($this->request->is('options')) {
            return $this->getResponse()->withStatus(200);
        }

        // 3. Obtener los parámetros de la solicitud API
        $year = $this->request->getQuery('year', date('Y'));
        $quarter = $this->request->getQuery('quarter', 1);

        // 4. Reutilizar exactamente la misma lógica matemática del Core financiero
        $results = $this->getDashboardData($year, $quarter);

        // 5. Retornar el payload JSON estructurado para el frontend de React
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'metadata' => [
                    'year' => (int)$year, 
                    'quarter' => (int)$quarter
                ],
                'data' => $results
            ]));
    }

    /**
     * LÓGICA DE NEGOCIO CENTRALIZADA (CORE)
     * Reutiliza el procesamiento de datos, patrones de diseño y cálculos SOLID
     */
    protected function getDashboardData($year, $quarter)
    {
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

        return $results;
    }
}
