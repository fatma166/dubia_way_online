<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $tergat
 * @property int|null $zone_id
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $casts = [
		'status' => 'bool',
		'zone_id' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'image',
		'status',
		'tergat',
		'zone_id'
	];

    public function getDataAttribute()
    {
        return [
            "title"=> $this->title,
            "description"=> $this->description,
            "order_id"=> "",
            "image"=> $this->image,
            "type"=> "order_status"
        ];
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
}
