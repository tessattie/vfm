<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$discounts = array(0 => "HTG", 1 => "%");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/trucks">
            Utilisateurs
        </a></li>
        <li class="active"><?= $user->first_name." ".$user->last_name ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Fiche Utilisateur : <?= $user->first_name." ".$user->last_name ?>
        </div>
    <div class="panel-body articles-container">

    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
           <table class="table table-bordered" style="margin-bottom:60px">
               <thead>
                   <tr>
                       <th class="text-center">Nom</th>
                       <th class="text-center">Nom d'Utilisateur</th>
                       <th class="text-center">Rôle</th>
                       <th class="text-center">Statut</th>
                       <th class="text-center">Créé le</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td><?= $user->first_name." ".$user->last_name ?></td>
                       <td><?= $user->username ?></td>
                       <td><?= $user->role->name ?></td>
                       <td><?= ($user->status == 0) ? "<label class='label label-danger'>Inactif</label>" : "<label class='label label-success'>Actif</label>" ?></td>
                       <td><?= $user->created ?></td>
                   </tr>
               </tbody>
           </table>
        <hr>
        <h3><strong>Ventes Associées</strong></h3>
        <hr>
        <table class="table table-stripped" style="margin-bottom:60px">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Caissier</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Sous-total</th>
                    <th class="text-center">Taxe</th>
                    <th class="text-center">Réduction</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Chargé</th>
                    <th class="text-center">Sortie</th>
                    <th class="text-right">Date</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach ($user->sales as $sale): ?>
            <tr>
                <td><a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center"><?= $sale->has('user') ? $this->Html->link($sale->user->first_name." ".$sale->user->last_name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->name, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>
                
                <td class="text-center"><?= $this->Number->format($sale->subtotal) ?> HTG</td>
                <td class="text-center"><?= $this->Number->format($sale->taxe) ?> HTG</td>
                <td class="text-center"><?= $sale->discount.$discounts[$sale->discount_type] ?></td>
                <td class="text-center"><?= $this->Number->format($sale->total) ?> HTG</td>
                <?php if($sale->charged == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success">Oui</label></td>
                <?php endif; ?>

                <?php if($sale->sortie == 0) : ?>
                    <td class="text-center"><label class="label label-danger">Non</label></td>
                <?php else : ?>
                    <td class="text-center"><label class="label label-success">Oui</label></td>
                <?php endif; ?>
                
                <td class="text-right"><?= h($sale->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>


        <hr>
        <h3><strong>Clients Crées</strong></h3>
        <hr>
        <table class="table table-stripped" style="margin-bottom:60px">
                <thead> 
                    <th>Nom</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center">Limite de Crédit</th>
                    <th class="text-center">Réduction</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-center"></th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach($user->customers as $customer) : ?>
            <?php if($customer->id != 1) : ?>
                <tr>
                    <td class="text-left"><?= $customer->first_name." ".$customer->last_name ?></td>
                    <td class="text-center"><?= $customer->email ?></td>
                    <td class="text-center"><?= $customer->phone ?></td>
                    <td class="text-center"><?= number_format($customer->credit_limit, 2, ".", ",") ?> USD</td>
                    <td class="text-center"><?= $customer->discount ?> <?= $discounts[$customer->discount_type] ?></td>
                    <td class="text-center"><?= $customer->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>

        <hr>
        <h3><strong>Camions Crées</strong></h3>
        <hr>
        <table class="table table-stripped">
                <thead> 
                    <th>Immatriculation</th>
                    <th class="text-center">Volume</th>
                    <th class="text-center">Date de création</th>
                </thead>
            <tbody> 
        <?php foreach($user->trucks as $truck) : ?>
                <tr>
                    <td class="text-left"><?= $this->Html->image('trucks/'.$truck->photo, ["width" => "60px", "height" => "auto"]); ?> <a href="<?= ROOT_DIREC ?>/trucks/view/<?= $truck->id ?>"><?= $truck->immatriculation ?></a></td>
                    <td class="text-center"><?= $truck->volume ?> m3</td>
                    <td class="text-right"><?= $truck->created ?></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->





<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Trucks'), ['controller' => 'Trucks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Truck'), ['controller' => 'Trucks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cards'), ['controller' => 'Cards', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Card'), ['controller' => 'Cards', 'action' => 'add']) ?> </li>
    </ul>
</nav>

<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($user->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    
    <div class="related">
        <h4><?= __('Related Cards') ?></h4>
        <?php if (!empty($user->cards)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->cards as $cards): ?>
            <tr>
                <td><?= h($cards->id) ?></td>
                <td><?= h($cards->code) ?></td>
                <td><?= h($cards->name) ?></td>
                <td><?= h($cards->created) ?></td>
                <td><?= h($cards->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Cards', 'action' => 'view', $cards->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Cards', 'action' => 'edit', $cards->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cards', 'action' => 'delete', $cards->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cards->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Customers') ?></h4>
        <?php if (!empty($user->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Credit Limit') ?></th>
                <th scope="col"><?= __('Phone') ?></th>
                <th scope="col"><?= __('Discount') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Discount Type') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Customer Number') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->first_name) ?></td>
                <td><?= h($customers->last_name) ?></td>
                <td><?= h($customers->email) ?></td>
                <td><?= h($customers->credit_limit) ?></td>
                <td><?= h($customers->phone) ?></td>
                <td><?= h($customers->discount) ?></td>
                <td><?= h($customers->created) ?></td>
                <td><?= h($customers->modified) ?></td>
                <td><?= h($customers->discount_type) ?></td>
                <td><?= h($customers->user_id) ?></td>
                <td><?= h($customers->customer_number) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Invoices') ?></h4>
        <?php if (!empty($user->invoices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->invoices as $invoices): ?>
            <tr>
                <td><?= h($invoices->id) ?></td>
                <td><?= h($invoices->customer_id) ?></td>
                <td><?= h($invoices->user_id) ?></td>
                <td><?= h($invoices->total) ?></td>
                <td><?= h($invoices->status) ?></td>
                <td><?= h($invoices->created) ?></td>
                <td><?= h($invoices->modified) ?></td>
                <td><?= h($invoices->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invoices', 'action' => 'delete', $invoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Payments') ?></h4>
        <?php if (!empty($user->payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Id') ?></th>
                <th scope="col"><?= __('Method Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Rate Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->payments as $payments): ?>
            <tr>
                <td><?= h($payments->id) ?></td>
                <td><?= h($payments->sale_id) ?></td>
                <td><?= h($payments->method_id) ?></td>
                <td><?= h($payments->amount) ?></td>
                <td><?= h($payments->rate_id) ?></td>
                <td><?= h($payments->created) ?></td>
                <td><?= h($payments->modified) ?></td>
                <td><?= h($payments->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales') ?></h4>
        <?php if (!empty($user->sales)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Number') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Truck Id') ?></th>
                <th scope="col"><?= __('Taxe') ?></th>
                <th scope="col"><?= __('Discount') ?></th>
                <th scope="col"><?= __('Subtotal') ?></th>
                <th scope="col"><?= __('Charged') ?></th>
                <th scope="col"><?= __('Sortie') ?></th>
                <th scope="col"><?= __('Pointofsale Id') ?></th>
                <th scope="col"><?= __('Hidden') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Discount Type') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->sales as $sales): ?>
            <tr>
                <td><?= h($sales->id) ?></td>
                <td><?= h($sales->sale_number) ?></td>
                <td><?= h($sales->status) ?></td>
                <td><?= h($sales->user_id) ?></td>
                <td><?= h($sales->customer_id) ?></td>
                <td><?= h($sales->truck_id) ?></td>
                <td><?= h($sales->taxe) ?></td>
                <td><?= h($sales->discount) ?></td>
                <td><?= h($sales->subtotal) ?></td>
                <td><?= h($sales->charged) ?></td>
                <td><?= h($sales->sortie) ?></td>
                <td><?= h($sales->pointofsale_id) ?></td>
                <td><?= h($sales->hidden) ?></td>
                <td><?= h($sales->created) ?></td>
                <td><?= h($sales->modified) ?></td>
                <td><?= h($sales->discount_type) ?></td>
                <td><?= h($sales->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sales', 'action' => 'view', $sales->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sales', 'action' => 'edit', $sales->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sales', 'action' => 'delete', $sales->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sales->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Trucks') ?></h4>
        <?php if (!empty($user->trucks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Immatriculation') ?></th>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= __('Volume') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->trucks as $trucks): ?>
            <tr>
                <td><?= h($trucks->id) ?></td>
                <td><?= h($trucks->immatriculation) ?></td>
                <td><?= h($trucks->photo) ?></td>
                <td><?= h($trucks->volume) ?></td>
                <td><?= h($trucks->created) ?></td>
                <td><?= h($trucks->modified) ?></td>
                <td><?= h($trucks->status) ?></td>
                <td><?= h($trucks->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Trucks', 'action' => 'view', $trucks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Trucks', 'action' => 'edit', $trucks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Trucks', 'action' => 'delete', $trucks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
