<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserNotification
 *
 * @property int $id
 * @property string|null $data
 * @property bool $status
 * @property int|null $user_id
 * @property int|null $vendor_id
 * @property int|null $delivery_man_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserNotification extends Model
{
	protected $table = 'user_notifications';

	protected $casts = [
		'status' => 'bool',
		'user_id' => 'int',
		'vendor_id' => 'int',
		'delivery_man_id' => 'int'
	];

	protected $fillable = [
		'data',
		'status',
		'user_id',
		'vendor_id',
		'delivery_man_id'
	];
    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
}
