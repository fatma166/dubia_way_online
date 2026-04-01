<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RestaurantSchedule
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $day
 * @property Carbon|null $opening_time
 * @property Carbon|null $closing_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RestaurantSchedule extends Model
{
	protected $table = 'restaurant_schedule';

	protected $casts = [
		'restaurant_id' => 'int',
		'day' => 'int',
		'opening_time' => 'datetime',
		'closing_time' => 'datetime'
	];

	protected $fillable = [
		'restaurant_id',
		'day',
		'opening_time',
		'closing_time'
	];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
