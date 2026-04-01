<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryManWallet
 * 
 * @property int $id
 * @property int $delivery_man_id
 * @property float $collected_cash
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float $total_earning
 * @property float $total_withdrawn
 * @property float $pending_withdraw
 *
 * @package App\Models
 */
class DeliveryManWallet extends Model
{
	protected $table = 'delivery_man_wallets';

	protected $casts = [
		'delivery_man_id' => 'int',
		'collected_cash' => 'float',
		'total_earning' => 'float',
		'total_withdrawn' => 'float',
		'pending_withdraw' => 'float'
	];

	protected $fillable = [
		'delivery_man_id',
		'collected_cash',
		'total_earning',
		'total_withdrawn',
		'pending_withdraw'
	];
}
