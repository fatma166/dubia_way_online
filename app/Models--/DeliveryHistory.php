<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryHistory
 * 
 * @property int $id
 * @property int|null $order_id
 * @property int|null $delivery_man_id
 * @property Carbon|null $time
 * @property string|null $longitude
 * @property string|null $latitude
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DeliveryHistory extends Model
{
	protected $table = 'delivery_histories';

	protected $casts = [
		'order_id' => 'int',
		'delivery_man_id' => 'int',
		'time' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'delivery_man_id',
		'time',
		'longitude',
		'latitude',
		'location'
	];
}
