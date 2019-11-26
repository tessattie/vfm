<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Payments</li>
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
            <table class="table table-stripped datatable">
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
            <?php if($customer->id != 1) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/customers/view/<?= $customer->id ?>" target="_blank"><?= $customer->first_name." ".$customer->last_name ?></a></td>
                    <td class="text-center"><?= $customer->email ?></td>
                    <td class="text-center"><?= $customer->phone ?></td>
                    <td class="text-center"><?= number_format($customer->credit_limit, 2, ".", ",") ?> USD</td>
                    <td class="text-center"><?= $customer->discount ?> <?= $types_reductions[$customer->discount_type] ?></td>
                    <td class="text-center"><?= $customer->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/customers/edit/<?= $customer->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
    </div>
</div><!--End .articles-->



<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable();
} );</script>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Methods'), ['controller' => 'Methods', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Method'), ['controller' => 'Methods', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['controller' => 'Rates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payments index large-9 medium-8 columns content">
    <h3><?= __('Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('method_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $this->Number->format($payment->id) ?></td>
                <td><?= $payment->has('sale') ? $this->Html->link($payment->sale->id, ['controller' => 'Sales', 'action' => 'view', $payment->sale->id]) : '' ?></td>
                <td><?= $payment->has('method') ? $this->Html->link($payment->method->name, ['controller' => 'Methods', 'action' => 'view', $payment->method->id]) : '' ?></td>
                <td><?= $this->Number->format($payment->amount) ?></td>
                <td><?= $payment->has('rate') ? $this->Html->link($payment->rate->name, ['controller' => 'Rates', 'action' => 'view', $payment->rate->id]) : '' ?></td>
                <td><?= h($payment->created) ?></td>
                <td><?= h($payment->modified) ?></td>
                <td><?= $payment->has('user') ? $this->Html->link($payment->user->id, ['controller' => 'Users', 'action' => 'view', $payment->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
