<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Accounts Controller
 *
 * @property \App\Model\Table\AccountsTable $Accounts
 *
 * @method \App\Model\Entity\Account[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $accounts = $this->Accounts->find("all", array("order" => array("Accounts.customer_id DESC")))->contain(['Customers', 'Users', 'Rates']);

        $this->set(compact('accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => ['Customers', 'Users', 'Rates', 'Transactions' => ['Sales']]
        ]);

        $transaction = $this->Accounts->Transactions->newEntity();
        $transactions = $this->Accounts->Transactions->find("list", array("conditions" => array("account_id" => $id)));
        $sales = $this->Accounts->Transactions->Sales->find("list", array("conditions" => array("customer_id" => $account->customer_id)));

        $this->set('account', $account);
        $this->set('transaction', $transaction);
        $this->set('transactions', $transactions);
        $this->set('sales', $sales);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Compte Sauvegardé'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de sauvegarder ce compte. Réessayez plus-tard ou appelez votre administrateur'));
        }
        $customers = $this->Accounts->Customers->find('list', ['limit' => 200]);
        $users = $this->Accounts->Users->find('list', ['limit' => 200]);
        $rates = $this->Accounts->Rates->find('list', ['limit' => 200]);
        $this->set(compact('account', 'customers', 'users', 'rates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Compte Sauvegardé'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de mettre à jour ce compte. Réessayez plus-tard ou appelez votre administrateur'));
        }
        $customers = $this->Accounts->Customers->find('list', ['limit' => 200]);
        $users = $this->Accounts->Users->find('list', ['limit' => 200]);
        $rates = $this->Accounts->Rates->find('list', ['limit' => 200]);
        $this->set(compact('account', 'customers', 'users', 'rates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->Accounts->get($id);
        if ($this->Accounts->delete($account)) {
            $this->Flash->success(__('Compte supprimé'));
        } else {
            $this->Flash->error(__('Vous ne pouvez pas supprimer ce compte.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
