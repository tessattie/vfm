<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale[]|\Cake\Collection\CollectionInterface $sales
 */

$discounts = array(0 => "HTG", 1 => "%");
$ouinon = array(0=> "Non", 1 => "Oui");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Ventes</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Ventes
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/sales/add">
                                                <em class="fa fa-plus"></em> Nouvelle Vente
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Caissier</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Camion</th>
                    <th class="text-center">Sous-total</th>
                    <th class="text-center">Taxe</th>
                    <th class="text-center">Réduction</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Chargé</th>
                    <th class="text-center">Sortie</th>
                    <th class="text-center">Date</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td class="text-center"><a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center"><?= $sale->has('user') ? $this->Html->link($sale->user->first_name." ".$sale->user->last_name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></td>
                
                
                
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
                
                <td class="text-center"><?= h($sale->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
