<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WithdrawRequest
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $admin_id
 * @property string $transaction_note
 * @property float $amount
 * @property bool $approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class WithdrawRequest extends Model
{
	protected $table = 'withdraw_requests';

	protected $casts = [
		'vendor_id' => 'int',
		'admin_id' => 'int',
		'amount' => 'float',
		'approved' => 'bool'
	];

	protected $fillable = [
		'vendor_id',
		'admin_id',
		'transaction_note',
		'amount',
		'approved'
	];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
}
