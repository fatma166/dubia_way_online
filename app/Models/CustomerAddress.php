<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerAddress
 * 
 * @property int $id
 * @property string $address_type
 * @property string $contact_person_number
 * @property string|null $address
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $user_id
 * @property string|null $contact_person_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $floor
 * @property string|null $road
 * @property string|null $house
 *
 * @package App\Models
 */
class CustomerAddress extends Model
{
	protected $table = 'customer_addresses';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'address_type',
		'contact_person_number',
		'address',
		'latitude',
		'longitude',
		'user_id',
		'contact_person_name',
		'floor',
		'road',
		'house'
	];
}
