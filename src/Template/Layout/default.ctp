<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'VFM';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('datepicker3.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#"><span>VF</span> MATERIAUX</a>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <span class="fa fa-user" style="font-size: 28px;margin-top: -5px;margin-left: 1px;"></span>
                    </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/view/<?= $user_connected['id'] ?>"><span class="fa fa-user">&nbsp;</span> Profil</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/logout"><span class="fa fa-power-off">&nbsp;</span> Déconnexion</a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
         
            <div class="profile-usertitle" style="margin:auto;width:100%">
                <div class="profile-usertitle-name text-center" style="margin-top:12px"><?= $user_connected['first_name']." ".$user_connected['last_name'] ?></div>
                <div class="profile-usertitle-status text-center"><span class="indicator label-success"></span>En ligne</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <!-- <form role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Recherche" style="font-size: 15px;">
            </div>
        </form>
 -->        <ul class="nav menu">
            <li><a href="<?= ROOT_DIREC ?>"><em class="fa fa-home">&nbsp;</em> Accueil</a></li>
            
            <li class="parent <?= ($this->request->getParam('controller') == 'Sales') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-4">
                <em class="fa fa-cc">&nbsp;</em> Ventes <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-4">
                    <li><a href="<?= ROOT_DIREC ?>/sales/summary"><em class="fa fa-arrow-right">&nbsp;</em> Résumé</a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales">
                        <span class="fa fa-arrow-right">&nbsp;</span> Rapport
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Products' || $this->request->getParam('controller') == 'Categories') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-1">
                <em class="fa fa-shopping-cart">&nbsp;</em> Catalogue <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1">
                    <li class="<?= ($this->request->getParam('controller') == 'Products') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/products">
                        <span class="fa fa-arrow-right">&nbsp;</span> Produits
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Categories') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/categories">
                        <span class="fa fa-arrow-right">&nbsp;</span> Catégories
                    </a></li>
                    <li><a class=""  href="<?= ROOT_DIREC ?>/products/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouveau Produit
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Pointofsales' || $this->request->getParam('controller') == 'Rates' || $this->request->getParam('controller') == 'Methods') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-3">
                <em class="fa fa-cog">&nbsp;</em> Configuration <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-3">
                    <li class="<?= ($this->request->getParam('controller') == 'Pointofsales') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/pointofsales"><em class="fa fa-arrow-right">&nbsp;</em> POS</a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Rates') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/rates">
                        <span class="fa fa-arrow-right">&nbsp;</span> Taux du jour
                    </a></li>
                    <li  class="<?= ($this->request->getParam('controller') == 'Methods') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/methods">
                        <span class="fa fa-arrow-right">&nbsp;</span> Méthodes de Paiement
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Users' || $this->request->getParam('controller') == 'Roles' || $this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-2">
                <em class="fa fa-users">&nbsp;</em> Utilisateurs <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li class="<?= ($this->request->getParam('controller') == 'Users') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/users">
                        <span class="fa fa-arrow-right">&nbsp;</span> Utilisateurs
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Roles') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/roles">
                        <span class="fa fa-arrow-right">&nbsp;</span> Rôles
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a class="" href="<?= ROOT_DIREC ?>/cards">
                        <span class="fa fa-arrow-right">&nbsp;</span> Cartes
                    </a></li>
                    <li><a class=""  href="<?= ROOT_DIREC ?>/users/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouvel Utilisateur
                    </a></li>
                </ul>
            </li>

            <li class="parent <?= ($this->request->getParam('controller') == 'Customers' || $this->request->getParam('controller') == 'Invoices' || $this->request->getParam('controller') == 'Payments') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-5">
                <em class="fa fa-cc">&nbsp;</em> Clients <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-5">
                    <li class="<?= ($this->request->getParam('controller') == 'Customers') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/customers"><em class="fa fa-arrow-right">&nbsp;</em> Clients</a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Invoices') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/invoices">
                        <span class="fa fa-arrow-right">&nbsp;</span> Factures
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Payments') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/payments"><em class="fa fa-arrow-right">&nbsp;</em> Paiements</a></li>
                    <li><a class=""  href="<?= ROOT_DIREC ?>/customers/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouveau Client
                    </a></li>
                </ul>
            </li>

            <li class="<?= ($this->request->getParam('controller') == 'Trucks') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/trucks"><em class="fa fa-truck">&nbsp;</em> Camions</a></li>
            <li><a  href="<?= ROOT_DIREC ?>/users/logout"><em class="fa fa-power-off">&nbsp;</em> Déconnexion</a></li>
        </ul>
    </div><!--/.sidebar-->
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        
            <?= $this->fetch('content') ?>

        <footer>

        </footer>

    </div>

    <?= $this->Html->script("jquery-1.11.1.min.js") ?>
    <?= $this->Html->script("bootstrap.js") ?>
    <?= $this->Html->script("bootstrap-datepicker.js") ?>
    <?= $this->Html->script("custom.js") ?>
    <style type="text/css">
        div.message.success{
            background: #dff0d8;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
        div.message.error{
            background: #f2dede;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
    </style>
</body>
</html>
