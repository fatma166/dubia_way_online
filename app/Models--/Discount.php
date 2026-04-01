<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Discount
 *
 * @property int $id
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
 * @property float $min_purchase
 * @property float $max_discount
 * @property float $discount
 * @property string $discount_type
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Discount extends Model
{
	protected $table = 'discounts';

	protected $casts = [
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'start_time' => 'datetime',
		'end_time' => 'datetime',
		'min_purchase' => 'float',
		'max_discount' => 'float',
		'discount' => 'float',
		'restaurant_id' => 'int'
	];

	protected $fillable = [
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		'min_purchase',
		'max_discount',
		'discount',
		'discount_type',
		'restaurant_id'
	];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


    public function scopeValidate($query)
    {
        $query->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->whereTime('start_time','<=',date('H:i:s'))->whereTime('end_time','>=',date('H:i:s'));
    }
}
