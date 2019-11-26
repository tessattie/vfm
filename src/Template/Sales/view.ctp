<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
$discounts = array(0 => "HTG", 1 => "%");
$currency = " HTG";
if($sale->status == 0){
    $currency = " USD";
}
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/ventes">
            Ventes
        </a></li>
        <li class="active">Fiche #<?= $sale->sale_number ?></li>
    </ol>
</div>
<div id="invoice">
    <div class="invoice overflow-auto">
    <?php if($sale->status == 0) : ?>
    <p class= "bg bg-success" style="padding:10px;text-align:center"> Fiche Crédit</p>
<?php endif; ?>
        <div style="min-width: 600px">
            <main>
                <div class="row contacts">
                    <div class="col-md-6 invoice-to">
                        <div class="text-gray-light">FICHE #<?= $sale->sale_number ?></div>
                        <div class="text-gray-light">Client : <?= $sale->has('customer') ? $this->Html->link($sale->customer->first_name." ".$sale->customer->last_name, ['controller' => 'Customers', 'action' => 'view', $sale->customer->id]) : '' ?></div>
                        <div class="text-gray-light">Camion : <?= $sale->has('truck') ? $this->Html->link($sale->truck->immatriculation, ['controller' => 'Trucks', 'action' => 'view', $sale->truck->id]) : '' ?></div>
                        <div class="text-gray-light">Caissier : <?= $sale->has('user') ? $this->Html->link($sale->user->first_name." ".$sale->user->last_name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></div>
                    </div>
                    <div class="col-md-6 invoice-details">
                        <div class="date">Date : <?= $sale->created ?></div>
                        <div class="date">Chargé : <?= ($sale->charged == 0) ? "<label class='label label-danger'>Non</label>" : "<label class='label label-success'>Oui</label>" ?></div>
                        <div class="date">Sorti : <?= ($sale->sortie == 0) ? "<label class='label label-danger'>Non</label>" : "<label class='label label-success'>Oui</label>" ?></div>

                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0" id="editedTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">PRODUIT</th>
                            <th class="text-center">PRIX (M3)</th>
                            <th class="text-center">CAPACITE CAMION</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sale->products_sales as $sp) : ?>
                        <tr>
                            <td class="no text-center">1</td>
                            <td class="text-left"><h3>
                                <a href="<?= ROOT_DIREC ?>/products/view/<?= $sp->id ?>" target="_blank">
                                <?= $sp->product->name ?>
                                </a>
                                </h3>
                            </td>
                            <td class="unit text-center"><?= number_format($sp->price,2, ".", ",") ?> <?= $currency ?></td>
                            <td class="qty text-center"><?= $sp->quantity ?> m3</td>
                            <td class="total"><?= number_format($sp->price*$sp->quantity,2, ".", ",") ?><?= $currency ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SOUS-TOTAL</td>
                            <td><?= number_format($sale->subtotal,2, ".", ",") ?> <?= $currency ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TAXE</td>
                            <td>(Inclu)</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">REDUCTION</td>
                            <td><?= $sale->discount.$discounts[$sale->discount_type] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TOTAL</td>
                            <td><?= number_format($sale->total,2, ".", ",") ?> <?= $currency ?></td>
                        </tr>
                    </tfoot>
                </table>
                <?php if($sale->status != 0) : ?>

                    <?php $currencies = array(1 => "HTG", 2 => "USD"); $paidHTG = 0; $paidUSD = 0; ?>
                        <?php foreach ($sale->transactions as $payments): ?>
                            <?php  
                                if($payments->account->rate_id == 2){
                                    $paidHTG = $paidHTG + $payments->amount*$payments->daily_rate;
                                }else{
                                    if($payments->type == 1){
                                        $paidHTG = $paidHTG - $payments->amount;
                                    }else{
                                        $paidHTG = $paidHTG + $payments->amount;
                                    }
                                    
                                }
                            ?>
                        <?php endforeach; ?>
                <table class="table table-stripped table-hover">
                    <thead>
                    <tr><th colspan="2"><h3>Paiements 
                    <?php if(($sale->total - $paidHTG) > 0) : ?>
                    <button class = "btn btn-success" data-toggle="modal" data-target="#newTransactionUSD" style="float:right;margin-left:5px"><em class="fa fa-plus"></em> USD </button> <button class = "btn btn-danger" data-toggle="modal" data-target="#newTransactionHTG" style="float:right"><em class="fa fa-plus"></em> HTG</button>
                <?php endif; ?>
                    </h3></th></tr>
                            <tr>
                            <th scope="col">Numéro</th>
                            <th scope="col" class="text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $currencies = array(1 => "HTG", 2 => "USD"); $paidHTG = 0; $paidUSD = 0; ?>
                        <?php foreach ($sale->transactions as $payments): ?>
                            <?php  
                                if($payments->account->rate_id == 2){
                                    $paidHTG = $paidHTG + $payments->amount*$payments->daily_rate;
                                }else{
                                    if($payments->type == 1){
                                        $paidHTG = $paidHTG - $payments->amount;
                                    }else{
                                        $paidHTG = $paidHTG + $payments->amount;
                                    }
                                    
                                }
                            ?>
                            <tr>
                                <td><?= h($payments->transaction_number) ?></td>
                                <?php if($payments->type == 1) : ?>
                                    <td class="text-right color-red"><strong>- <?= number_format($payments->amount, 2, ".", ",") ?> <?= $currencies[$payments->account->rate_id ] ?></strong></td>
                                <?php else : ?>
                                    <td class="text-right" style="color:green"><strong><?= number_format($payments->amount, 2, ".", ",") ?> <?= $currencies[$payments->account->rate_id ] ?></strong></td>
                                <?php endif; ?>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php $maxHTG = $sale->total - $paidHTG ?>

                <!-- Modal -->
<div class="modal fade" id="newTransactionUSD" tabindex="-1" role="dialog" aria-labelledby="newTransactionUSD" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <?= $this->Form->create($transaction) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouvelle Transaction USD</h5>
      </div>
      <div class="modal-body">
        <?php  
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $sale->customer_id]);
            echo $this->Form->control('type', ['type' => 'hidden', 'value' => 2]);
            echo $this->Form->control('sale_id', ['type' => 'hidden', 'value' => $sale->id]);
            echo $this->Form->control('amount', ['label' => "Montant", 'placeholder' => "Montant", "class" => "form-control", "style" => "margin-bottom:15px", "type" => "number"]);
            echo $this->Form->control('currency', ['label' => "Devise", 'value' => 2, "class" => "form-control", "style" => "margin-bottom:15px", "options" => array(2 => "USD")]);
            echo $this->Form->control('description', ['label' => "Description", "placeholder" => "Ex : Ajustement Balance", "class" => "form-control", "style" => "margin-bottom:15px"]);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success')) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>
  </div>
</div>

<div class="modal fade" id="newTransactionHTG" tabindex="-1" role="dialog" aria-labelledby="newTransactionHTG" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <?= $this->Form->create($transaction) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouvelle Transaction HTG</h5>
      </div>
      <div class="modal-body">
        <?php  
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $sale->customer_id]);
            echo $this->Form->control('type', ['type' => 'hidden', 'value' => 2]);
            echo $this->Form->control('sale_id', ['type' => 'hidden', 'value' => $sale->id]);
            echo $this->Form->control('amount', ['label' => "Montant", 'placeholder' => "Montant", "class" => "form-control", "style" => "margin-bottom:15px", 'type' => "number"]);
            echo $this->Form->control('currency', ['label' => "Devise", 'value' => 1, "class" => "form-control", "style" => "margin-bottom:15px", "options" => array(1 => "HTG")]);
            echo $this->Form->control('description', ['label' => "Description", "placeholder" => "Ex : Ajustement Balance", "class" => "form-control", "style" => "margin-bottom:15px"]);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success')) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>
  </div>
</div>
            <?php endif; ?>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<style type="text/css">
    #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 45px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice #editedTable {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice #editedTable td,.invoice #editedTable th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice #editedTable th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice #editedTable td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice #editedTable .total,.invoice #editedTable .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice #editedTable .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice #editedTable .unit {
    background: #ddd
}

.invoice #editedTable .total {
    background: #3989c6;
    color: #fff
}

.invoice #editedTable tbody tr:last-child td {
    border: none
}

.invoice #editedTable tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice #editedTable tfoot tr:first-child td {
    border-top: none
}

.invoice #editedTable tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice #editedTable tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>