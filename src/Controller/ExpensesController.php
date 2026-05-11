<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Expenses Controller
 *
 * @property \App\Model\Table\ExpensesTable $Expenses
 */
class ExpensesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Expenses->find()
            ->contain(['Companies']);
        $expenses = $this->paginate($query);

        $this->set(compact('expenses'));
    }

    /**
     * View method
     *
     * @param string|null $id Expense id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $expense = $this->Expenses->get($id, contain: ['Companies']);
        $this->set(compact('expense'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expense = $this->Expenses->newEmptyEntity();
        if ($this->request->is('post')) {
            $expense = $this->Expenses->patchEntity($expense, $this->request->getData());
            if ($this->Expenses->save($expense)) {
                $this->Flash->success(__('The expense has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expense could not be saved. Please, try again.'));
        }
        $companies = $this->Expenses->Companies->find('list', limit: 200)->all();
        // Inicializamos vacíos para el efecto cascada
        $departments = [];
        $categories = [];
        
        $this->set(compact('expense', 'companies', 'departments', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Expense id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $expense = $this->Expenses->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expense = $this->Expenses->patchEntity($expense, $this->request->getData());
            if ($this->Expenses->save($expense)) {
                $this->Flash->success(__('The expense has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expense could not be saved. Please, try again.'));
        }
        $companies = $this->Expenses->Companies->find('list', limit: 200)->all();
        $this->set(compact('expense', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Expense id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $expense = $this->Expenses->get($id);
        if ($this->Expenses->delete($expense)) {
            $this->Flash->success(__('The expense has been deleted.'));
        } else {
            $this->Flash->error(__('The expense could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // Función 1: Obtener departamentos por empresa
    public function getDepartments($companyId = null)
    {
        $this->request->allowMethod(['get','ajax']);

        $departmentsTable = $this->fetchTable('Departments');

        $departments = $departmentsTable
            ->find('list')
            ->where(['company_id' => $companyId])
            ->toArray();
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($departments));
    }

    // Función 2: Obtener categorías por departamento
    public function getCategories($departmentId = null)
    {
        $this->request->allowMethod(['get','ajax']);

        $categoriesTable = $this->fetchTable('Categories');

        $categories = $categoriesTable
            ->find('list')
            ->where(['department_id' => $departmentId])
            ->toArray();
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($categories));
    }
}
