<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLog
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon $date
 * @property Carbon|null $online
 * @property Carbon|null $offline
 * @property float $working_hour
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TimeLog extends Model
{
	protected $table = 'time_logs';

	protected $casts = [
		'user_id' => 'int',
		'date' => 'datetime',
		'online' => 'datetime',
		'offline' => 'datetime',
		'working_hour' => 'float'
	];

	protected $fillable = [
		'user_id',
		'date',
		'online',
		'offline',
		'working_hour'
	];
   /* public function deliveryman()
    {
        return $this->belongsTo(TimeLog::class, 'user_id', 'id');
    }*/
}
