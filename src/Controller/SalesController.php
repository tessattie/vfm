<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;


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
        $from = date("Y-m-d 00:00:00");
        $to = date("Y-m-d 23:59:59");

        if ($this->request->is(['patch', 'post', 'put'])) {
            $from = $this->request->data['from']['year']."-".$this->request->data['from']['month']."-".$this->request->data['from']['day']." 00:00:00";
            $to = $this->request->data['to']['year']."-".$this->request->data['to']['month']."-".$this->request->data['to']['day']." 23:59:59";
        }
        $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales']);

        $this->set(compact('sales'));
    }


    public function search(){
        if ($this->request->is(['patch', 'post', 'put'])){
            $sale = $this->Sales->find("all", array("conditions" => array("sale_number" => $this->request->getData()['sale_ident'])));
            foreach($sale as $s){
                $id = $s->id;
            } 

            return $this->redirect(['action' => 'view', $id]);
        }
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
        $this->loadModel('Rates');
        $sale = $this->Sales->get($id, [
            'contain' => ['Users', 'Customers', 'Trucks', 'Pointofsales', 'ProductsSales', 'Payments' => ['Methods', 'Rates'], 'Transactions' => ['Accounts']]
        ]);
        $this->loadModel("Transactions");
        $transaction = $this->Transactions->newEntity();
        $rate = $this->Rates->get(2);

        if ($this->request->is(['patch', 'post', 'put'])){
            
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            $transaction->user_id = $this->Auth->user()['id'];
            $transaction->daily_rate = $rate->amount;
            $transaction->customer_id = 1;
            $transaction->transaction_number = date("dmY").($this->Transactions->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
            $account = $this->Transactions->Accounts->find("all", array('conditions' => array("customer_id" => 1, "rate_id" => $this->request->getData()['currency'])));
            foreach($account as $a){
                $transaction->account_id = $a->id;
            }
            $this->Transactions->save($transaction);
            $transactions = $this->Transactions->find("all", array("conditions" => array("sale_id" => $sale->id)))->contain(['Accounts']);
            $paidHTG = 0;
            foreach($transactions as $t){
                if($t->account->rate_id == 2){
                    $paidHTG = $paidHTG + $t->amount*$t->daily_rate;
                }else{
                    $paidHTG = $paidHTG + $t->amount;
                }
            }

            if($sale->total < $paidHTG){
                $sale->monnaie = $paidHTG - $sale->total;
                if($new = $this->Sales->save($sale)){
                    $trans = $this->Transactions->newEntity();
                    $trans->user_id = $this->Auth->user()['id'];
                    $trans->daily_rate = $rate->amount;
                    $trans->customer_id = 1;
                    $trans->transaction_number = date("dmY").($this->Transactions->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
                    $trans->amount = $new['monnaie'];
                    $trans->type = 1;
                    $trans->account_id = 3;
                    $trans->sale_id = $new['id'];
                    $trans->description = "Monnaie";
                    $this->Transactions->save($trans);
                }
            }
        }

        $sale = $this->Sales->get($id, [
            'contain' => ['Users', 'Customers', 'Trucks', 'Pointofsales', 'ProductsSales' => ['Products'], 'Payments' => ['Methods', 'Rates'], 'Transactions' => ['Accounts']]
        ]);

        $this->loadModel('Rates');
        $this->set('sale', $sale); $this->set('transaction', $transaction); $this->set('rate', $rate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Rates');
        $sale = $this->Sales->newEntity();
        if ($this->request->is('post')) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            $trucks = $this->Sales->Trucks->find("all", array('conditions' => array('immatriculation' => $this->request->getData()['truck_id'])));
            foreach($trucks as $tr){
                $truck = $tr;
            }
            $product = $this->Sales->Products->get($this->request->getData()['product_id']);
            if(isset($this->request->getData()['is_credit_sale'])){
                $sale_total = $truck->volume*$product->credit_price;
                $sale->status = 0;
            }else{
                $sale_total = $truck->volume*$product->cash_price;
                $sale->status = 1;
            }
            $sale->subtotal = $sale_total;
            $sale->taxe = 0;
            if($sale->discount_type == 0){
                $discount = $sale_total*$this->request->getData()['discount']/100;
            }else{
                $discount = $this->request->getData()['discount'];
            }
            $sale->pointofsale_id = 1;
            $sale->total = $sale->subtotal + $sale->taxe - $discount;
            if($sale->charged == 1){
                $sale->charged_time = date("Y-m-d H:i:s");
                $sale->charged_user_id = $this->Auth->User()['id'];
            }

            if($sale->sortie == 1){
                $sale->sortie_time = date("Y-m-d H:i:s");
                $sale->sortie_user_id = $this->Auth->User()['id'];
            }
            $sale->truck_id = $truck->id;
            $sale->sale_number = date("dmY").($this->Sales->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
            $sale->user_id = $this->Auth->User()['id'];
            // if($sale->status != 0){
            //     foreach($this->request->getData()['Payments'] as $payment){
            //         $this->loadModel('Rates');
            //         if($payment['rate_id'] == 2){
            //             $usd = $this->Rates->get(2);
            //             $ptotal = $usd->amount * $payment['amount'];
            //         }else{
            //             $ptotal = $payment['amount'];
            //         }
            //     }
            //     $sale->monnaie = $ptotal - $sale->total;
            // }
            $sale->monnaie = 0;
            // debug($this->request->getData());
            // debug($sale); 
            // die();
            if ($new = $this->Sales->save($sale)) {
                $new = $this->Sales->get($new['id']);
                if($new->status == 0){
                    $this->loadModel('Transactions');
                    $trans = $this->Transactions->newEntity(); 
                    $trans->user_id = $this->Auth->user()['id'];
                    $trans->daily_rate = $this->Rates->get(2)->amount;
                    $trans->transaction_number = date("dmY").($this->Transactions->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
                    $account = $this->Transactions->Accounts->find("all", array('conditions' => array("customer_id" => $new->customer_id, "rate_id" => 2)));
                    foreach($account as $a){
                        $trans->account_id = $a->id;
                    }

                    $trans->amount = $new->total;
                    $trans->type = 1;
                    $trans->customer_id = $new->customer_id;
                    $trans->sale_id = $new['id'];
                    $trans->description = "Achat Crédit";
                    $this->Transactions->save($trans);
                }

                $ps = $this->Sales->ProductsSales->newEntity();
                $ps->product_id = $this->request->getData()['product_id'];
                $ps->sale_id = $new->id;
                if($new->status == 0){
                    $ps->price = $product->credit_price;
                    $ps->totalPrice = $product->credit_price*$truck->volume;
                } else{
                    $ps->price = $product->cash_price;
                    $ps->totalPrice = $product->cash_price*$truck->volume;
                }
                $ps->quantity = $truck->volume;
                $this->Sales->ProductsSales->save($ps);


                if(!empty($this->request->getData()['requisition_id'])){
                    $rs = $this->Sales->RequisitionsSales->newEntity();
                    $rp = $this->Sales->RequisitionsSales->Requisitions->RequisitionsProducts->find("all", array('conditions' => array('requisition_id' => $this->request->getData()['requisition_id'], "product_id" => $this->request->getData()['product_id'])));
                    foreach($rp as $rpp){
                        $rpp->used = $rpp->used + 1;
                        $this->Sales->RequisitionsSales->Requisitions->RequisitionsProducts->save($rpp); 
                    }
                    
                    $rs ->sale_id = $new->id;
                    $rs->requisition_id = $this->request->getData()['requisition_id'];
                    $this->Sales->RequisitionsSales->save($rs);
                }

                return $this->redirect(['action' => 'view', $new['id']]);
            }
        }
        $users = $this->Sales->Users->find('list');
        $customers = $this->Sales->Customers->find('list', [ "order" => ['last_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);
        $this->loadModel('Rates');
        $rate = $this->Rates->get(2);
        $rates = $this->Rates->find('list');
        $trucks = $this->Sales->Trucks->find('list');
        $methods = $this->Sales->Payments->Methods->find('list', array('conditions' => array('id <>' => 3)));
        $products = $this->Sales->Products->find('all', ['order' => array('name ASC')]);
        $this->set(compact('sale', 'users', 'customers', 'trucks', 'products', 'rate', "methods", 'rates'));
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

                return $this->redirect(['action' => 'index']);
            }
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
        $this->request->allowMethod(['post', 'delete', 'get']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function products(){
        $conn = ConnectionManager::get('default');
        if ($this->request->is(['put', 'patch', 'post'])){

            $from = $this->request->data['from']['year']."-".$this->request->data['from']['month']."-".$this->request->data['from']['day']." 00:00:00";
            $to = $this->request->data['to']['year']."-".$this->request->data['to']['month']."-".$this->request->data['to']['day']." 23:59:59";

            $product_list = $conn->query("SELECT p.`name`, p.`cash_price`, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."'
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold 
                FROM `products` p "); 


        }else{
            $product_list = $conn->query("SELECT p.`name`, p.`cash_price`, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".date("Y-m-d 00:00:00")."' AND o.created <= '".date("Y-m-d 23:59:59")."' 
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold 
                FROM `products` p "); 
        }
        
        
        $this->set(compact('product_list'));
    }
}
