<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Produits</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Produits
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/products/add">
                                                <em class="fa fa-plus"></em> Nouveau Produit
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
                    <th class="text-center">Catégorie</th>
                    <th class="text-center">Prix Cash</th>
                    <th class="text-center">Prix Crédit</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($products as $product) : ?>
                <tr>
                    <td><?= $product->name ?></td>
                    <td class="text-center"><?= $product->category->name ?></td>
                    <td class="text-center"><?= number_format($product->cash_price, 2, ".", ",") ?> HTG</td>
                    <td class="text-center"><?= number_format($product->credit_price, 2, ".", ",") ?> USD</td>
                    <?php if($product->status == 1) : ?>
                        <td class="text-center">  <span class="label label-success"> <?= $status[$product->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center">  <span class="label label-danger"> <?= $status[$product->status] ?></span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $product->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/products/edit/<?= $product->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->


