<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoyaltyPointTransaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $transaction_id
 * @property float $credit
 * @property float $debit
 * @property float $balance
 * @property string|null $reference
 * @property string|null $transaction_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LoyaltyPointTransaction extends Model
{
	protected $table = 'loyalty_point_transactions';

	protected $casts = [
		'user_id' => 'int',
		'credit' => 'float',
		'debit' => 'float',
		'balance' => 'float'
	];

	protected $fillable = [
		'user_id',
		'transaction_id',
		'credit',
		'debit',
		'balance',
		'reference',
		'transaction_type'
	];
    /**
     * Get the user that owns the LoyaltyPointTransaction
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
