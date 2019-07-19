<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Customers', 'Trucks', 'Pointofsales']
        ];
        $sales = $this->paginate($this->Sales);

        $this->set(compact('sales'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Users', 'Customers', 'Trucks', 'Pointofsales', 'Products', 'Payments' => ['Methods', 'Rates']]
        ]);

        $this->set('sale', $sale);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sale = $this->Sales->newEntity();
        if ($this->request->is('post')) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            if ($this->Sales->save($sale)) {
                $this->Flash->success(__('The sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale could not be saved. Please, try again.'));
        }
        $users = $this->Sales->Users->find('list', ['limit' => 200]);
        $customers = $this->Sales->Customers->find('list', ['limit' => 200]);
        $trucks = $this->Sales->Trucks->find('list', ['limit' => 200]);
        $pointofsales = $this->Sales->Pointofsales->find('list', ['limit' => 200]);
        $products = $this->Sales->Products->find('list', ['limit' => 200]);
        $this->set(compact('sale', 'users', 'customers', 'trucks', 'pointofsales', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            if ($this->Sales->save($sale)) {
                $this->Flash->success(__('The sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale could not be saved. Please, try again.'));
        }
        $users = $this->Sales->Users->find('list', ['limit' => 200]);
        $customers = $this->Sales->Customers->find('list', ['limit' => 200]);
        $trucks = $this->Sales->Trucks->find('list', ['limit' => 200]);
        $pointofsales = $this->Sales->Pointofsales->find('list', ['limit' => 200]);
        $products = $this->Sales->Products->find('list', ['limit' => 200]);
        $this->set(compact('sale', 'users', 'customers', 'trucks', 'pointofsales', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
            $this->Flash->success(__('The sale has been deleted.'));
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
