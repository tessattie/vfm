<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
$discounts = array(0 => "HTG", 1 => "%");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/trucks">
            Clients
        </a></li>
        <li class="active"><?= $customer->first_name." ".$customer->last_name ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Fiche Client : <?= $customer->first_name." ".$customer->last_name ?>
        </div>
    <div class="panel-body articles-container">

    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
           <table class="table table-bordered" style="margin-bottom:60px">
               <thead>
                   <tr>
                       <th class="text-center">Nom</th>
                       <th class="text-center">Email</th>
                       <th class="text-center">Téléphone</th>
                       <th class="text-center">Créé par</th>
                       <th class="text-center">Limite de Crédit</th>
                       <th class="text-center">Réduction</th>
                       <th class="text-center">Créé le</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td><?= $customer->first_name." ".$customer->last_name ?></td>
                       <td><?= $customer->email ?></td>
                       <td><?= $customer->phone ?></td>
                       <td><?= $customer->user->first_name." ".$customer->user->last_name ?></td>
                       <td><?= number_format($customer->credit_limit, 2, ".", ",") ?> USD</td>
                       <td><?= $customer->discount." ".$discounts[$customer->discount_type] ?></td>
                       <td><?= $customer->created ?></td>
                   </tr>
               </tbody>
           </table>
        <hr>
        <h3><strong>Ventes Associées</strong></h3>
        <hr>
        <table class="table table-stripped">
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
        <?php foreach ($customer->sales as $sale): ?>
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
        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->



