<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account[]|\Cake\Collection\CollectionInterface $accounts
 */
$rates= array(1 => "HTG", 2 => "USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Comptes</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Comptes
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Numéro</th>
                    <th class="text-center">Devise</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Créé par</th>
                    <th class="text-center">Date de création</th>
                    <th class="text-right">Balance</th>
                </thead>
            <tbody> 
        <?php foreach($accounts as $account) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/accounts/view/<?= $account->id ?>" target="_blank"><?= $account->account_number ?></a></td>
                    <?php if($account->rate_id == 1) : ?>
                        <td class="text-center"><span class="label label-primary">HTG</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-success">USD</span></td>
                    <?php endif; ?>

                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $account->customer->id ?>" target="_blank"><?= strtoupper($account->customer->last_name) . " " . ucfirst(strtolower($account->customer->first_name)) ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/users/view/<?= $account->user->id ?>" target="_blank"><?= strtoupper($account->user->last_name) . " " . ucfirst(strtolower($account->user->first_name)) ?></a></td>
                    <td class="text-center"><?= $account->created ?></td>
                    <?php if($account->balance >= 0 ) : ?>
                        <td class="text-right"><span class="label label-success"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php else : ?>
                        <td class="text-right"><span class="label label-danger"><?= number_format($account->balance, 2, ".", ",") ?> <?= $rates[$account->rate_id] ?></span></td>
                    <?php endif; ?>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
    </div>
</div><!--End .articles-->



<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable(
        {
            "ordering": false
        }
        );
} );</script>
