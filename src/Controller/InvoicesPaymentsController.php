<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InvoicesPayments Controller
 *
 * @property \App\Model\Table\InvoicesPaymentsTable $InvoicesPayments
 *
 * @method \App\Model\Entity\InvoicesPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoicesPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Invoices', 'Payments']
        ];
        $invoicesPayments = $this->paginate($this->InvoicesPayments);

        $this->set(compact('invoicesPayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoices Payment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoicesPayment = $this->InvoicesPayments->get($id, [
            'contain' => ['Invoices', 'Payments']
        ]);

        $this->set('invoicesPayment', $invoicesPayment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoicesPayment = $this->InvoicesPayments->newEntity();
        if ($this->request->is('post')) {
            $invoicesPayment = $this->InvoicesPayments->patchEntity($invoicesPayment, $this->request->getData());
            if ($this->InvoicesPayments->save($invoicesPayment)) {
                $this->Flash->success(__('The invoices payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoices payment could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoicesPayments->Invoices->find('list', ['limit' => 200]);
        $payments = $this->InvoicesPayments->Payments->find('list', ['limit' => 200]);
        $this->set(compact('invoicesPayment', 'invoices', 'payments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoices Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoicesPayment = $this->InvoicesPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoicesPayment = $this->InvoicesPayments->patchEntity($invoicesPayment, $this->request->getData());
            if ($this->InvoicesPayments->save($invoicesPayment)) {
                $this->Flash->success(__('The invoices payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoices payment could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoicesPayments->Invoices->find('list', ['limit' => 200]);
        $payments = $this->InvoicesPayments->Payments->find('list', ['limit' => 200]);
        $this->set(compact('invoicesPayment', 'invoices', 'payments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoices Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoicesPayment = $this->InvoicesPayments->get($id);
        if ($this->InvoicesPayments->delete($invoicesPayment)) {
            $this->Flash->success(__('The invoices payment has been deleted.'));
        } else {
            $this->Flash->error(__('The invoices payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
