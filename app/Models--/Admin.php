<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin
 *
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string|null $phone
 * @property string $email
 * @property string|null $image
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $role_id
 * @property int|null $zone_id
 *
 * @package App\Models
 */

class Admin extends Authenticatable
{
   // use Notifiable;
	protected $table = 'admins';

	protected $casts = [
		'role_id' => 'int',
		'zone_id' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'f_name',
		'l_name',
		'phone',
		'email',
		'image',
		'password',
		'remember_token',
		'role_id',
		'zone_id'
	];
    public function role(){
        return $this->belongsTo(AdminRole::class,'role_id');
    }

    public function scopeZone($query)
    {
        if(isset(auth('admin')->user()->zone_id))
        {
            return $query->where('zone_id', auth('admin')->user()->zone_id);
        }
        return $query;
    }

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class,'admin_id', 'id');
    }
}
