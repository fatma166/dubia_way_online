<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhoneVerification
 * 
 * @property int $id
 * @property string $phone
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PhoneVerification extends Model
{
	protected $table = 'phone_verifications';

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'phone',
		'token'
	];
}
