<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * 
 * @property int $id
 * @property string|null $country
 * @property string|null $currency_code
 * @property string|null $currency_symbol
 * @property float|null $exchange_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Currency extends Model
{
	protected $table = 'currencies';

	protected $casts = [
		'exchange_rate' => 'float'
	];

	protected $fillable = [
		'country',
		'currency_code',
		'currency_symbol',
		'exchange_rate'
	];
}
