<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoicesPayment Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $payment_id
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Payment $payment
 */
class InvoicesPayment extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'invoice_id' => true,
        'payment_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'invoice' => true,
        'payment' => true
    ];
}
