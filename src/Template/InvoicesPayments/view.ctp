<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoicesPayment $invoicesPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoices Payment'), ['action' => 'edit', $invoicesPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoices Payment'), ['action' => 'delete', $invoicesPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoicesPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoices Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoices Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="invoicesPayments view large-9 medium-8 columns content">
    <h3><?= h($invoicesPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td><?= $invoicesPayment->has('invoice') ? $this->Html->link($invoicesPayment->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $invoicesPayment->invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $invoicesPayment->has('payment') ? $this->Html->link($invoicesPayment->payment->id, ['controller' => 'Payments', 'action' => 'view', $invoicesPayment->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($invoicesPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($invoicesPayment->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($invoicesPayment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($invoicesPayment->modified) ?></td>
        </tr>
    </table>
</div>
