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
class Offer extends Model
{
	protected $table = 'offers';



	protected $guarded = ['id'];
    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
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
