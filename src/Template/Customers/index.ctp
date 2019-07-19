<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Clients</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Clients
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/customers/add">
                                                <em class="fa fa-plus"></em> Nouveau Client
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
                    <th>Nom</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center">Limite de Crédit</th>
                    <th class="text-center">Réduction</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($customers as $customer) : ?>
                <tr>
                    <td><?= $customer->first_name." ".$customer->last_name ?></td>
                    <td class="text-center"><?= $customer->email ?></td>
                    <td class="text-center"><?= $customer->phone ?></td>
                    <td class="text-center"><?= number_format($customer->credit_limit, 2, ".", ",") ?> USD</td>
                    <td class="text-center"><?= $customer->discount ?> <?= $types_reductions[$customer->discount_type] ?></td>
                    <td class="text-center"><?= $customer->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
    </div>
</div><!--End .articles-->



