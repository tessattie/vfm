<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>">
            Produits
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer Product : <?= $product->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cog"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/products">
                                                 Retour
                                            </a></li>
                                            <li><?= $this->Form->postLink(
                                                     __('Supprimer'),
                                                    ['action' => 'delete', $product->id],
                                                    ['confirm' => __('Etes-vous sûr de vouloir supprimer le produit {0}?', $product->name)]
                                                )       
                                            ?></li>
                                            <li><a href="<?= ROOT_DIREC ?>/products/add">
                                               Nouveau Produit
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">       
           <?= $this->Form->create($product) ?>
                <div class="row">
                <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('category_id', array('class' => 'form-control', "label" => "Catégorie *", "options" => $categories)); ?></div>
                    
                </div>  
                <div class="row" style="margin-top:15px">
                <div class="col-md-4"><?= $this->Form->control('cash_price', array('class' => 'form-control', "label" => "Prix Cash (HTG) *", "placeholder" => "Prix Cash (HTG)")); ?></div>
                <div class="col-md-4"><?= $this->Form->control('credit_price', array('class' => 'form-control', "type" => "text", "label" => "Prix Crédit (USD) *", "placeholder" => "Prix crédit (USD)")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Statut *")); ?></div>
    
                </div>   
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->