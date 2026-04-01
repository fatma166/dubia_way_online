<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RestaurantWallet
 *
 * @property int $id
 * @property int $vendor_id
 * @property float $total_earning
 * @property float $total_withdrawn
 * @property float $pending_withdraw
 * @property float $collected_cash
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RestaurantWallet extends Model
{
	protected $table = 'restaurant_wallets';

	protected $casts = [
		'vendor_id' => 'int',
		'total_earning' => 'float',
		'total_withdrawn' => 'float',
		'pending_withdraw' => 'float',
		'collected_cash' => 'float'
	];

	protected $fillable = [
		'vendor_id',
		'total_earning',
		'total_withdrawn',
		'pending_withdraw',
		'collected_cash'
	];
    protected $appends = ['balance'];
    public function getBalanceAttribute()
    {
        return $this->total_earning - ($this->total_withdrawn + $this->pending_withdraw + $this->collected_cash);
    }
}
