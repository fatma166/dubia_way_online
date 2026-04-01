<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\RestaurantScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MailConfig
 *
 * @property int $id
 * @property string $name
 * @property string $host
 * @property string $driver
 * @property string $port
 * @property string $username
 * @property string $email
 * @property string $encryption
 * @property string $password
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MailConfig extends Model
{
	protected $table = 'mail_configs';

	protected $casts = [
		'restaurant_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'host',
		'driver',
		'port',
		'username',
		'email',
		'encryption',
		'password',
		'restaurant_id'
	];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    protected static function booted()
    {
        if(auth('vendor')->check())
        {
            static::addGlobalScope(new RestaurantScope);
        }
    }
}
