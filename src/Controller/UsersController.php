<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->Users->find('all', array('order' => array("Users.created DESC")))->contain(['Roles']);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Cards', 'Customers', 'Sales' => ["Trucks", "Customers"], 'Trucks']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($ident = $this->Users->save($user)) {
                $this->Flash->success(__('L\'utilisateur a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder l\'utilisateur . Réessayez plus-tard'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $cards = $this->Users->Cards->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'cards'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Cards']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $cards = $this->Users->Cards->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'cards'));
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
        $this->request->allowMethod(['post', 'delete', 'get']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Utilisateur Supprimé'));
        } else {
            $this->Flash->error(__('Impossible de supprimer cet utilisateur'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function login(){
        $this->viewBuilder()->layout('login');
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            // debug($user); die();
            if ($user) {
                if($user['status'] == false){
                    $this->Flash->error(__('Ce compte est bloqué. Contactez votre administrateur'));
                }else{
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }else{
                $this->Flash->error(__('Vos identifiants so incorrectes'));
            }
        }
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

}
