<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $customers = $this->paginate($this->Customers);

        $this->set(compact('customers'));
    }

    public function find(){
        if($this->request->is("ajax")){
            $customer = $this->Customers->find('all', array('conditions' => array("id" => $this->request->getData()['id'])))->contain(["Requisitions" => ['RequisitionsProducts'], 'Accounts' => ['Rates']]);
            foreach($customer as $c){
                $balance = 0;
                foreach($c->accounts as $account){
                    if($account->rate_id == 1){
                        $balance = $balance + ( $account->balance / $account->rate->amount );
                    }else{
                        $balance = $balance + $account->balance;
                    }
                }
                $c->credit_available = $c->credit_limit + $balance;
            }
            if($customer->count() == 0){
                echo json_encode("false");
            }else{
               echo json_encode($customer->toArray()); 
            }
            
        }
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Users', 'Sales' => ['Users', 'Trucks']]
        ]);

        $this->set('customer', $customer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            $customer->user_id = $this->Auth->user()['id'];
            if ($ident = $this->Customers->save($customer)) {
                $this->Flash->success(__('Le client a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder le client. Réessayez plus-tard'));
        }
        $users = $this->Customers->Users->find('list', ['limit' => 200]);
        $this->set(compact('customer', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $users = $this->Customers->Users->find('list', ['limit' => 200]);
        $this->set(compact('customer', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', "get"]);
        // $customer = $this->Customers->get($id);
        // if ($this->Customers->delete($customer)) {
        //     $this->Flash->success(__('The customer has been deleted.'));
        // } else {
        //     $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        // }

        return $this->redirect(['action' => 'index']);
    }
}
