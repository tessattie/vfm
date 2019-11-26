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
        </div>
    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-m-12">
            <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('from', array('class' => 'form-control', "label" => "De : ", "type" => "date")); ?>
                    </div>

                    <div class="col-md-4">
                        <?= $this->Form->control('to', array('class' => 'form-control', "label" => "A : ", "type" => "date")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <hr>
        </div>
    </div>
            <table class="table table-stripped datatable">
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
                
                
                
                <td class="text-center"><?= $this->Number->format($sale->subtotal) ?> <?= ($sale->status == 1) ? "HTG" : "USD" ?></td>
                <td class="text-center"><?= $this->Number->format($sale->taxe) ?> <?= ($sale->status == 1) ? "HTG" : "USD" ?></td>
                <?php if($sale->discount_type == 0) : ?>
                    <td class="text-center"><?= $sale->discount ?>  <?= ($sale->status == 1) ? "HTG" : "USD" ?></td>
                <?php else : ?>
                    <td class="text-center"><?= $sale->discount.$discounts[$sale->discount_type] ?></td>
                <?php endif; ?>
                
                <td class="text-center"><?= $this->Number->format($sale->total) ?> <?= ($sale->status == 1) ? "HTG" : "USD" ?></td>
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
                <td class="text-right"><a href="<?= ROOT_DIREC ?>/sales/edit/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> <a href="<?= ROOT_DIREC ?>/sales/delete/<?= $sale->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-trash color-red"></span></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
            "ordering": false
        });
    })
</script>

<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>