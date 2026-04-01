<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Otp_code extends Model
{
	protected $table = 'otp_codes';
	public $timestamps = false;

	protected  $guarded=['id'];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

}
