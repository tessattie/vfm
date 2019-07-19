<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
$discounts = array(0 => "HTG", 1 => "%");
$ouinon = array(0=> "Non", 1 => "Oui");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/trucks">
            Camions
        </a></li>
        <li class="active">Camion <?= $truck->immatriculation ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Fiche Camion <?= $truck->immatriculation ?>
        </div>
    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-md-12 text-center">
            <?= $this->Html->image('trucks/'.$truck->photo, ["width" => "auto", "height" => "auto"]); ?>
        </div>
    </div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-12 text-center">
            <table class="table table-bordered" style="margin-bottom:60px">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Plaque</th>
                    <th class="text-center"  rowspan="2">Créé par</th>
                    <th class="text-center" colspan="3">Benne</th>
                    <th class="text-center" colspan="2">Vérrin</th>
                    <th class="text-center" rowspan="2">Volume</th>
                </tr>
                <tr><th class="text-center">Longueur</th><th class="text-center">Largeur</th><th class="text-center">Hauteur</th><th class="text-center">Largeur</th><th class="text-center">Hauteur</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $truck->immatriculation ?></td>
                    <td><?= $truck->user->first_name." ".$truck->user->last_name ?></td>
                    <td><?= $truck->length ?>m</td>
                    <td><?= $truck->width ?>m</td>
                    <td><?= $truck->height ?>m</td>
                    <td><?= $truck->widthv ?>m</td>
                    <td><?= $truck->heightv ?>m</td>
                    <td><?= $truck->volume ?>m3</td>
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
                    <th class="text-center">Client</th>
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
        <?php foreach ($truck->sales as $sale): ?>
            <tr>
                <td><a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank"><?= $sale->sale_number ?></a></td>
                <td class="text-center"><?= $sale->has('user') ? $this->Html->link($sale->user->first_name." ".$sale->user->last_name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                <td class="text-center"><?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
                
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



