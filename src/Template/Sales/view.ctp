<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
$discounts = array(0 => "HTG", 1 => "%");

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
        <div style="min-width: 600px">
            <main>
                <div class="row contacts">
                    <div class="col-md-6 invoice-to">
                        <div class="text-gray-light">FICHE #<?= $sale->sale_number ?></div>
                        <div class="text-gray-light">Client : <?= $sale->customer->first_name." ".$sale->customer->last_name ?></div>
                        <div class="text-gray-light">Camion : <?= $sale->truck->immatriculation ?></div>
                        <div class="text-gray-light">Caissier : <?= $sale->user->first_name." ".$sale->user->last_name ?></div>
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
                    <?php foreach ($sale->products as $sp) : ?>
                        <tr>
                            <td class="no text-center">1</td>
                            <td class="text-left"><h3>
                                <a target="<?= ROOT_DIREC ?>/products/view/<?= $sp->id ?>">
                                <?= $sp->name ?>
                                </a>
                                </h3>
                            </td>
                            <td class="unit text-center"><?= number_format($sp->cash_price,2, ".", ",") ?> HTG</td>
                            <td class="qty text-center"><?= $sale->truck->volume ?> m3</td>
                            <td class="total"><?= number_format($sp->cash_price*$sale->truck->volume,2, ".", ",") ?> HTG</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SOUS-TOTAL</td>
                            <td><?= number_format($sale->subtotal,2, ".", ",") ?> HTG</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TAXE</td>
                            <td>(Inclus)</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">REDUCTION</td>
                            <td><?= $sale->discount.$discounts[$sale->discount_type] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TOTAL</td>
                            <td><?= number_format($sale->total,2, ".", ",") ?> HTG</td>
                        </tr>
                    </tfoot>
                </table>

                <table class="table table-stripped table-hover">
                    <thead>
                    <tr><th colspan="2"><h3>Paiements</h3></th></tr>
                            <tr>
                            <th scope="col">Type</th>
                            <th scope="col" class="text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sale->payments as $payments): ?>
                            <tr>
                                <td><?= h($payments->method->name) ?></td>
                                <td class="text-right"><?= number_format($payments->amount, 2, ".", ",") ?> <?= $payments->rate->name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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