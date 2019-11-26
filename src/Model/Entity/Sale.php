<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property string $sale_number
 * @property int $status
 * @property int $user_id
 * @property int $customer_id
 * @property int $truck_id
 * @property float $taxe
 * @property float $discount
 * @property float $subtotal
 * @property int $charged
 * @property int $sortie
 * @property int $pointofsale_id
 * @property int $hidden
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $discount_type
 * @property float $total
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Truck $truck
 * @property \App\Model\Entity\Pointofsale $pointofsale
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Product[] $products
 */
class Sale extends Entity
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
        'sale_number' => true,
        'monnaie' => true,
        'status' => true,
        'user_id' => true,
        'customer_id' => true,
        'truck_id' => true,
        'taxe' => true,
        'discount' => true,
        'subtotal' => true,
        'charged' => true,
        'sortie' => true,
        'pointofsale_id' => true,
        'hidden' => true,
        'created' => true,
        'modified' => true,
        'discount_type' => true,
        'total' => true,
        'user' => true,
        'customer' => true,
        'truck' => true,
        'pointofsale' => true,
        'payments' => true,
        'products' => true
    ];
}
