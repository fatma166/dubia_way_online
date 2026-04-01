<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class OrderPaymentTransaction extends Model
{
	protected $table = 'order_payment_transaction';
    public $timestamps = true;

    public $appends = [ 'image_url'];

	protected  $guarded=['id'];


    public function order()
    {
        return $this->hasOne(Order::class);
    }
    public function customer()
    {
        return $this->hasOne(User::class);
    }
 public function scopeNotRefunded($query)
    {
        return $query->where(function($query){
            $query->whereNotIn('status', ['refunded_with_delivery_charge', 'refunded_without_delivery_charge'])->orWhereNull('status');
        });
    }

}
