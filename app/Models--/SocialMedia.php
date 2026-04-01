<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialMedia
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SocialMedia extends Model
{
	protected $table = 'social_media';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'link',
		'status'
	];
    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
}
