<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 */
class BudgetsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Budgets->find()
            ->contain(['Categories']);
        $budgets = $this->paginate($query);

        $this->set(compact('budgets'));
    }

    /**
     * View method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $budget = $this->Budgets->get($id, contain: ['Categories']);
        $this->set(compact('budget'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $budget = $this->Budgets->newEmptyEntity();
        if ($this->request->is('post')) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->getData());
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The budget could not be saved. Please, try again.'));
        }

        $departments = $this->fetchTable('Departments')->find('list', limit: 200)->all();
        $categories = [];

        $this->set(compact('budget', 'categories', 'departments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $budget = $this->Budgets->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->getData());
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The budget could not be saved. Please, try again.'));
        }
        $categories = $this->Budgets->Categories->find('list', limit: 200)->all();
        $this->set(compact('budget', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $budget = $this->Budgets->get($id);
        if ($this->Budgets->delete($budget)) {
            $this->Flash->success(__('The budget has been deleted.'));
        } else {
            $this->Flash->error(__('The budget could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getCategories($departmentId = null)
    {
        // 1. Evitar que CakePHP intente renderizar un archivo .php de vista
        $this->autoRender = false;

        // Permitir solicitudes estándar GET (el fetch de JS viaja así)
        $this->request->allowMethod(['get', 'ajax']);

        // 2. Sintaxis correcta de CakePHP 5 usando argumentos nombrados
        $categories = $this->fetchTable('Categories')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['department_id' => $departmentId])
            ->toArray();

        // 3. Retornar la respuesta JSON limpia
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($categories));
    }
}
