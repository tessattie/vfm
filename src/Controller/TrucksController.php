<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * Trucks Controller
 *
 * @property \App\Model\Table\TrucksTable $Trucks
 *
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrucksController extends AppController
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
        $trucks = $this->paginate($this->Trucks);

        $this->set(compact('trucks'));
    }

    /**
     * View method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => ['Users', 'Sales' => ['Users', "Customers"]]
        ]);

        $this->set('truck', $truck);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $truck = $this->Trucks->newEntity();
        if ($this->request->is('post')) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            $featured_image = false;
            if(!empty($this->request->data['photo']['tmp_name'])){
                $featured_image = $this->checkfile($this->request->data['photo'], $truck->immatriculation, 'trucks');
            }
            if($featured_image != false){
                $truck->photo = $featured_image;
            }
            $truck->user_id = $this->Auth->user()['id']; 
            if ($ident = $this->Trucks->save($truck)) {
                $this->Flash->success(__('Le camion a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder le camion. Réessayez plus-tard'));
        }
        $users = $this->Trucks->Users->find('list', ['limit' => 200]);
        $this->set(compact('truck', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $old_photo = $truck->photo;
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());

            $featured_image = false;
            if(!empty($this->request->data['photo']['tmp_name'])){
                $featured_image = $this->checkfile($this->request->data['photo'], $truck->immatriculation, 'trucks');
            }

            if($featured_image != false){
                $truck->photo = $featured_image;
            }else{
                $truck->photo = $old_photo;
            }
            
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $users = $this->Trucks->Users->find('list', ['limit' => 200]);
        $this->set(compact('truck', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $truck = $this->Trucks->get($id);
        if ($this->Trucks->delete($truck)) {
            $this->Flash->success(__('Camion Supprimé'));
        } else {
            $this->Flash->error(__('Impossible de supprimer ce camion.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function find(){
        if($this->request->is("ajax")){
            $truck = $this->Trucks->find('all', array('conditions' => array("immatriculation" => $this->request->getData()['truck'])));
            if($truck->count() == 0){
                echo json_encode("false");
            }else{
               echo json_encode($truck->toArray()); 
            }
            
        }
        die();
    }
}
