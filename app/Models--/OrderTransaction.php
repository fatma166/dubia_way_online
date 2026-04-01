<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderTransaction
 *
 * @property int $id
 * @property int $vendor_id
 * @property int|null $delivery_man_id
 * @property int $order_id
 * @property float $order_amount
 * @property float $restaurant_amount
 * @property float $admin_commission
 * @property string $received_by
 * @property float $original_delivery_charge
 * @property float $tax
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float $delivery_charge
 * @property int|null $zone_id
 * @property float $dm_tips
 * @property float $delivery_fee_comission
 *
 * @package App\Models
 */
class OrderTransaction extends Model
{
	protected $table = 'order_transactions';

	protected $casts = [
		'vendor_id' => 'int',
		'delivery_man_id' => 'int',
		'order_id' => 'int',
		'order_amount' => 'float',
		'restaurant_amount' => 'float',
		'admin_commission' => 'float',
		'original_delivery_charge' => 'float',
		'tax' => 'float',
		'delivery_charge' => 'float',
		'zone_id' => 'int',
		'dm_tips' => 'float',
		'delivery_fee_comission' => 'float'
	];

	protected $fillable = [
		'vendor_id',
		'delivery_man_id',
		'order_id',
		'order_amount',
		'restaurant_amount',
		'admin_commission',
		'received_by',
		'original_delivery_charge',
		'tax',
		'status',
		'delivery_charge',
		'zone_id',
		'dm_tips',
		'delivery_fee_comission'
	];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeNotRefunded($query)
    {
        return $query->where(function($query){
            $query->whereNotIn('status', ['refunded_with_delivery_charge', 'refunded_without_delivery_charge'])->orWhereNull('status');
        });
    }
}
