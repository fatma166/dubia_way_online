<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailVerification
 * 
 * @property int $id
 * @property string|null $email
 * @property string|null $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmailVerification extends Model
{
	protected $table = 'email_verifications';

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'email',
		'token'
	];
}
