<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletTransaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $transaction_id
 * @property float $credit
 * @property float $debit
 * @property float $admin_bonus
 * @property float $balance
 * @property string|null $transaction_type
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class WalletTransaction extends Model
{
	protected $table = 'wallet_transactions';

	protected $casts = [
		'user_id' => 'int',
		'credit' => 'float',
		'debit' => 'float',
		'admin_bonus' => 'float',
		'balance' => 'float'
	];

	protected $fillable = [
		'user_id',
		'transaction_id',
		'credit',
		'debit',
		'admin_bonus',
		'balance',
		'transaction_type',
		'reference'
	];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
