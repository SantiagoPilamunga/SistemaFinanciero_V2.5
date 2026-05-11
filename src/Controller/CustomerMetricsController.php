<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CustomerMetrics Controller
 *
 * @property \App\Model\Table\CustomerMetricsTable $CustomerMetrics
 */
class CustomerMetricsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CustomerMetrics->find()
            ->contain(['Departments']);
        $customerMetrics = $this->paginate($query);

        $this->set(compact('customerMetrics'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Metric id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerMetric = $this->CustomerMetrics->get($id, contain: ['Departments']);
        $this->set(compact('customerMetric'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerMetric = $this->CustomerMetrics->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerMetric = $this->CustomerMetrics->patchEntity($customerMetric, $this->request->getData());
            if ($this->CustomerMetrics->save($customerMetric)) {
                $this->Flash->success(__('The customer metric has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer metric could not be saved. Please, try again.'));
        }
        $departments = $this->CustomerMetrics->Departments->find('list', limit: 200)->all();
        $this->set(compact('customerMetric', 'departments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Metric id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerMetric = $this->CustomerMetrics->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerMetric = $this->CustomerMetrics->patchEntity($customerMetric, $this->request->getData());
            if ($this->CustomerMetrics->save($customerMetric)) {
                $this->Flash->success(__('The customer metric has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer metric could not be saved. Please, try again.'));
        }
        $departments = $this->CustomerMetrics->Departments->find('list', limit: 200)->all();
        $this->set(compact('customerMetric', 'departments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Metric id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerMetric = $this->CustomerMetrics->get($id);
        if ($this->CustomerMetrics->delete($customerMetric)) {
            $this->Flash->success(__('The customer metric has been deleted.'));
        } else {
            $this->Flash->error(__('The customer metric could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
