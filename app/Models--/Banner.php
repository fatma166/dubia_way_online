<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string|null $image
 * @property bool $status
 * @property string $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $zone_id
 *
 * @package App\Models
 */
class Banner extends Model
{
	protected $table = 'banners';

	protected $casts = [
		'status' => 'bool',
		'zone_id' => 'int'
	];
    public $appends = [ 'image_url'];
	/*protected $fillable = [
		'title',
		'type',
		'image',
		'status',
		'data',
		'zone_id'
	];*/
	protected  $guarded=['id'];

    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

   /* protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }*/
}
