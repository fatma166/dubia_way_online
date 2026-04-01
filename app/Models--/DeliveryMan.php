<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryMan
 * 
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string $phone
 * @property string|null $email
 * @property string|null $identity_number
 * @property string|null $identity_type
 * @property string|null $identity_image
 * @property string|null $image
 * @property string $password
 * @property string|null $auth_token
 * @property string|null $fcm_token
 * @property int|null $zone_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $status
 * @property bool $active
 * @property bool $earning
 * @property int $current_orders
 * @property string $type
 * @property int|null $restaurant_id
 * @property int $order_count
 * @property int $assigned_order_count
 *
 * @package App\Models
 */
class DeliveryMan extends Model
{
	protected $table = 'delivery_men';

	protected $casts = [
		'zone_id' => 'int',
		'status' => 'bool',
		'active' => 'bool',
		'earning' => 'bool',
		'current_orders' => 'int',
		'restaurant_id' => 'int',
		'order_count' => 'int',
		'assigned_order_count' => 'int'
	];

	protected $hidden = [
		'password',
		'auth_token',
		'fcm_token'
	];

	protected $fillable = [
		'f_name',
		'l_name',
		'phone',
		'email',
		'identity_number',
		'identity_type',
		'identity_image',
		'image',
		'password',
		'auth_token',
		'fcm_token',
		'zone_id',
		'status',
		'active',
		'earning',
		'current_orders',
		'type',
		'restaurant_id',
		'order_count',
		'assigned_order_count'
	];
}
