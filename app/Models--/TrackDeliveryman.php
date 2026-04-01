<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TrackDeliveryman
 * 
 * @property int $id
 * @property int|null $order_id
 * @property int|null $delivery_man_id
 * @property string|null $longitude
 * @property string|null $latitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TrackDeliveryman extends Model
{
	protected $table = 'track_deliverymen';

	protected $casts = [
		'order_id' => 'int',
		'delivery_man_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'delivery_man_id',
		'longitude',
		'latitude'
	];
}
