<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * @property int $id
 * @property int $food_id
 * @property int $user_id
 * @property string|null $comment
 * @property string|null $attachment
 * @property int $rating
 * @property int|null $order_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $status
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';

	protected $casts = [
		'food_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int',
		'order_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'food_id',
		'user_id',
		'comment',
		'attachment',
		'rating',
		'order_id',
		'status'
	];
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }
}
