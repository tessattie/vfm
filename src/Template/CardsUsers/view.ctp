<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CardsUser $cardsUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cards User'), ['action' => 'edit', $cardsUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cards User'), ['action' => 'delete', $cardsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cardsUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cards Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cards User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cards'), ['controller' => 'Cards', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Card'), ['controller' => 'Cards', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cardsUsers view large-9 medium-8 columns content">
    <h3><?= h($cardsUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $cardsUser->has('user') ? $this->Html->link($cardsUser->user->id, ['controller' => 'Users', 'action' => 'view', $cardsUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Card') ?></th>
            <td><?= $cardsUser->has('card') ? $this->Html->link($cardsUser->card->name, ['controller' => 'Cards', 'action' => 'view', $cardsUser->card->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cardsUser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cardsUser->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cardsUser->modified) ?></td>
        </tr>
    </table>
</div>
