<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProvideDMEarning
 *
 * @property int $id
 * @property int $delivery_man_id
 * @property float $amount
 * @property string|null $method
 * @property string|null $ref
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProvideDMEarning extends Model
{
	protected $table = 'provide_d_m_earnings';

	protected $casts = [
		'delivery_man_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'delivery_man_id',
		'amount',
		'method',
		'ref'
	];

   /* public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }*/
}
