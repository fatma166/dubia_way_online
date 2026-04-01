<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RestaurantZone
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $zone_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RestaurantZone extends Model
{
	protected $table = 'restaurant_zone';

	protected $casts = [
		'restaurant_id' => 'int',
		'zone_id' => 'int'
	];

	protected $fillable = [
		'restaurant_id',
		'zone_id'
	];

}
