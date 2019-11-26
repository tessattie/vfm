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

        <div class="panel-body tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Ventes</a></li>
                <li><a href="#tab2" data-toggle="tab">Clients</a></li>
                <li><a href="#tab3" data-toggle="tab">Camions</a></li>
            </ul>
            <div class="tab-content" style="    border-left: 1px solid #f2f3f2;
    border-right: 1px solid #f2f3f2;
    border-bottom: 1px solid #f2f3f2;">
                <div class="tab-pane fade in active" id="tab1">
                    <table class="table table-stripped" style="margin-bottom:60px">
                            <thead> 
                                <th>Numéro</th>
                                <th class="text-center">Client</th>
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
                            <td class="text-center"><?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></td>
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
                <div class="tab-pane fade" id="tab2">
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
                                <td class="text-left"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>"><?= $customer->first_name." ".$customer->last_name ?></a></td>
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
                </div>
                <div class="tab-pane fade" id="tab3">
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
        </div>



        </div>
    </div>
        
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->





