<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class WalletTransactionRefrance extends Model
{
	protected $table = 'wallet_transaction_refrances';
    public $timestamps = false;



	protected  $guarded=['id'];





}
