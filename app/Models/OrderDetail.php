<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDetail
 *
 * @property int $id
 * @property int|null $food_id
 * @property int|null $order_id
 * @property float $price
 * @property string|null $food_details
 * @property string|null $variation
 * @property string|null $add_ons
 * @property float|null $discount_on_food
 * @property string $discount_type
 * @property int $quantity
 * @property float $tax_amount
 * @property string|null $variant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float $total_add_on_price
 * @property int|null $item_campaign_id
 *
 * @package App\Models
 */
class OrderDetail extends Model
{
	protected $table = 'order_details';

	protected $casts = [
		'food_id' => 'int',
		'order_id' => 'int',
		'price' => 'float',
		'discount_on_food' => 'float',
		'quantity' => 'int',
		'tax_amount' => 'float',
		'total_add_on_price' => 'float',
		'item_campaign_id' => 'int'
	];

	protected $fillable = [
		'food_id',
		'order_id',
		'price',
		'food_details',
		'variation',
		'add_ons',
		'discount_on_food',
		'discount_type',
		'quantity',
		'tax_amount',
		'variant',
		'total_add_on_price',
		'item_campaign_id'
	];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function vendor()
    {
        return $this->order->restaurant();
    }
    public function food()
    {
        return $this->belongsTo(Food::class,'food_id');
    }

}
