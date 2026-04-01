<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $code
 * @property Carbon|null $start_date
 * @property Carbon|null $expire_date
 * @property float $min_purchase
 * @property float $max_discount
 * @property float $discount
 * @property string $discount_type
 * @property string $coupon_type
 * @property int|null $limit
 * @property bool $status
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $data
 * @property int|null $total_uses
 *
 * @package App\Models
 */
class Coupon extends Model
{
	protected $table = 'coupons';

	protected $casts = [
		'start_date' => 'datetime',
		'expire_date' => 'datetime',
		'min_purchase' => 'float',
		'max_discount' => 'float',
		'discount' => 'float',
		'limit' => 'int',
		'status' => 'bool',
		'restaurant_id' => 'int',
		'total_uses' => 'int'
	];

	protected $fillable = [
		'title',
		'code',
		'start_date',
		'expire_date',
		'min_purchase',
		'max_discount',
		'discount',
		'discount_type',
		'coupon_type',
		'limit',
		'status',
		'restaurant_id',
		'compilation_id',
		'data',
		'total_uses'
	];
    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
   /* protected static function booted()
     {
      //if(auth('vendor')->check())
    //     {
           static::addGlobalScope(new RestaurantScope);
      //   }
     }*/
   public function restaurant(){
       return $this->hasOne(Restaurant::class,'id','restaurant_id');
   }
}
