<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Utilisateurs</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Utilisateurs
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/users/add">
                                                <em class="fa fa-plus"></em> Nouvel Utilisateur
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
                    <th class="text-center">Nom d'Utilisateur</th>
                    <th class="text-center">Rôle</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($users as $user) : ?>
                <tr>
                    <td><?= $user->first_name. " " . $user->last_name ?></td>
                    <td class="text-center"><?= $user->username ?></td>
                    <td class="text-center"><?= $user->role->name ?></td>
                    <?php if($user->status == 1) : ?>
                        <td class="text-center">  <span class="label label-success"> <?= $status[$user->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center">  <span class="label label-danger"> <?= $status[$user->status] ?></span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $user->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/users/edit/<?= $user->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->