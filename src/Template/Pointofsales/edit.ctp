<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pointofsale $pointofsale
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>">
            POS
        </a></li>
        <li class="active">Editer</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Editer POS : <?= $pointofsale->name ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cog"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/pointofsales">
                                                 Retour
                                            </a></li>
                                            <li><?= $this->Form->postLink(
                                                     __('Supprimer'),
                                                    ['action' => 'delete', $pointofsale->id],
                                                    ['confirm' => __('Etes-vous sûr de vouloir supprimer la carte {0}?', $pointofsale->name)]
                                                )       
                                            ?></li>
                                            <li><a href="<?= ROOT_DIREC ?>/users/add">
                                               Nouveau Produit
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
        </div>
    <div class="panel-body articles-container">       
           <?= $this->Form->create($pointofsale) ?>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Nom *", "placeholder" => "Nom")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('imei', array('class' => 'form-control', "label" => "IMEI *", "placeholder" => "IMEI")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('serial_number', array('class' => 'form-control', "label" => "Numéro de Série *", "placeholder" => "Numéro de Série")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('status', array('class' => 'form-control', "options" => $status, 'style' => "height:46px", "label" => "Statut *")); ?></div>
                    
                </div>  
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->