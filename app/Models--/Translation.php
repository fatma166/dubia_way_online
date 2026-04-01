<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * 
 * @property int $id
 * @property string $translationable_type
 * @property int $translationable_id
 * @property string $locale
 * @property string|null $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Translation extends Model
{
	protected $table = 'translations';

	protected $casts = [
		'translationable_id' => 'int'
	];

	protected $fillable = [
		'translationable_type',
		'translationable_id',
		'locale',
		'key',
		'value'
	];
}
