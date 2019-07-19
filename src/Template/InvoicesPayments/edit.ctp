<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoicesPayment $invoicesPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoicesPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoicesPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Invoices Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoicesPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($invoicesPayment) ?>
    <fieldset>
        <legend><?= __('Edit Invoices Payment') ?></legend>
        <?php
            echo $this->Form->control('invoice_id', ['options' => $invoices]);
            echo $this->Form->control('payment_id', ['options' => $payments]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
