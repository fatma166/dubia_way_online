<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VendorEmployee
 *
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string|null $phone
 * @property string $email
 * @property string|null $image
 * @property int $employee_role_id
 * @property int $vendor_id
 * @property int $restaurant_id
 * @property string $password
 * @property bool $status
 * @property string|null $remember_token
 * @property string|null $firebase_token
 * @property string|null $auth_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VendorEmployee extends Model
{
	protected $table = 'vendor_employees';

	protected $casts = [
		'employee_role_id' => 'int',
		'vendor_id' => 'int',
		'restaurant_id' => 'int',
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
		'image',
		'employee_role_id',
		'vendor_id',
		'restaurant_id',
		'password',
		'status',
		'remember_token',
		'firebase_token',
		'auth_token'
	];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function role(){
        return $this->belongsTo(EmployeeRole::class,'employee_role_id');
    }
}
