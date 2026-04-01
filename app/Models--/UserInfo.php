<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserInfo
 *
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $image
 * @property int|null $admin_id
 * @property int|null $user_id
 * @property int|null $vendor_id
 * @property int|null $deliveryman_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserInfo extends Model
{
	protected $table = 'user_infos';

	protected $casts = [
		'admin_id' => 'int',
		'user_id' => 'int',
		'vendor_id' => 'int',
		'deliveryman_id' => 'int'
	];

	protected $fillable = [
		'f_name',
		'l_name',
		'phone',
		'email',
		'image',
		'admin_id',
		'user_id',
		'vendor_id',
		'deliveryman_id'
	];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class, 'deliveryman_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
