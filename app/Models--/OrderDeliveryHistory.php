<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDeliveryHistory
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $delivery_man_id
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
 * @property string|null $start_location
 * @property string|null $end_location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OrderDeliveryHistory extends Model
{
	protected $table = 'order_delivery_histories';

	protected $casts = [
		'order_id' => 'int',
		'delivery_man_id' => 'int',
		'start_time' => 'datetime',
		'end_time' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'delivery_man_id',
		'start_time',
		'end_time',
		'start_location',
		'end_location'
	];
}
