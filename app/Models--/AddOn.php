<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\RestaurantScope;
use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AddOn
 *
 * @property int $id
 * @property string|null $name
 * @property float $price
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $status
 *
 * @package App\Models
 */
class AddOn extends Model
{
	protected $table = 'add_ons';

	protected $casts = [
		'price' => 'float',
		'restaurant_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'price',
		'restaurant_id',
		'status'
	];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    protected static function booted()
    {
        if(auth('vendor')->check() || auth('vendor_employee')->check())
        {
            static::addGlobalScope(new RestaurantScope);
        }
        static::addGlobalScope(new ZoneScope);

        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function($query){
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }
}
