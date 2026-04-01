<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class Vendor
 *
 * @property int $id
 * @property string $f_name
 * @property string|null $l_name
 * @property string $phone
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $admin_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $bank_name
 * @property string|null $branch
 * @property string|null $holder_name
 * @property string|null $account_no
 * @property string|null $image
 * @property bool|null $status
 * @property string|null $firebase_token
 * @property string|null $auth_token
 *
 * @package App\Models
 */
class Vendor extends Authenticatable
{
    use  SoftDeletes;
    use  HasFactory, Notifiable ;
	protected $table = 'vendors';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'admin_id' => 'int',
		'status' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'firebase_token',
		'auth_token'
	];

	protected $fillable = [
		'f_name',
		'l_name',
		'phone',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'admin_id',
		'bank_name',
		'branch',
		'holder_name',
		'account_no',
		'image',
		'status',
		'firebase_token',
		'auth_token'
	];
    public function this_week_orders()
    {
        return $this->hasManyThrough(Order::class, Restaurant::class)->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public function this_month_orders()
    {
        return $this->hasManyThrough(Order::class, Restaurant::class)->whereMonth('orders.created_at', date('m'))->whereYear('orders.created_at', date('Y'));
    }

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class,'vendor_id', 'id');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Restaurant::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
    public function withdrawrequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }
    public function wallet()
    {
        return $this->hasOne(RestaurantWallet::class);
    }
}
