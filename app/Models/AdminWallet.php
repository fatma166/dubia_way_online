<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminWallet
 *
 * @property int $id
 * @property int $admin_id
 * @property float $total_commission_earning
 * @property float $digital_received
 * @property float $manual_received
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float $delivery_charge
 *
 * @package App\Models
 */
class AdminWallet extends Model
{
	protected $table = 'admin_wallets';
    protected $fillable = ['admin_id'];
}
