<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $parent_id
 * @property int $position
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $priority
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'parent_id' => 'int',
		'position' => 'int',
		'status' => 'bool',
		'priority' => 'int'
	];

	protected $fillable = [
		'name',
		'image',
		'parent_id',
		'position',
		'status',
		'priority',
        'description',
        'product_quantity',
        'compilation_id',
        'restaurant_id'
	];

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function restaurant()
    {
        return $this->hasMany(Restaurant::class, 'restaurant_id');
    }



    /*protected static function booted()
    {
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }*/
}
