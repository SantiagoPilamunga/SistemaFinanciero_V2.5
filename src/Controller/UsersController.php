<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        // Obtenemos el ID del usuario que está operando actualmente
        $identity = $this->request->getAttribute('identity');
        $currentUserId = $identity ? $identity->getIdentifier() : null;

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario ha sido eliminado.'));

                // SI EL USUARIO BORRADO ES EL MISMO QUE ESTÁ LOGUEADO:
                if ($id == $currentUserId) {
                    $this->Authentication->logout(); // Destruimos su sesión
                    return $this->redirect(['action' => 'login']); // Lo mandamos al login
                }
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
        return $this->redirect(['controller' => 'Companies', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $this->Flash->error('Email o contraseña incorrectos');
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // Verificamos si hay una sesión activa antes de intentar cerrar
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }
        
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir las acciones de login y registro
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout']);
    }

    
}
