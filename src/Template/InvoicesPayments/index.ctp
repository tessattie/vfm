<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoicesPayment[]|\Cake\Collection\CollectionInterface $invoicesPayments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Invoices Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoicesPayments index large-9 medium-8 columns content">
    <h3><?= __('Invoices Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoicesPayments as $invoicesPayment): ?>
            <tr>
                <td><?= $this->Number->format($invoicesPayment->id) ?></td>
                <td><?= $invoicesPayment->has('invoice') ? $this->Html->link($invoicesPayment->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $invoicesPayment->invoice->id]) : '' ?></td>
                <td><?= $invoicesPayment->has('payment') ? $this->Html->link($invoicesPayment->payment->id, ['controller' => 'Payments', 'action' => 'view', $invoicesPayment->payment->id]) : '' ?></td>
                <td><?= $this->Number->format($invoicesPayment->status) ?></td>
                <td><?= h($invoicesPayment->created) ?></td>
                <td><?= h($invoicesPayment->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $invoicesPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoicesPayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoicesPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoicesPayment->id)]) ?>
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
