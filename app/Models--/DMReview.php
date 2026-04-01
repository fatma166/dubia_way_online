<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DMReview
 * 
 * @property int $id
 * @property int $delivery_man_id
 * @property int $user_id
 * @property int $order_id
 * @property string|null $comment
 * @property string|null $attachment
 * @property int $rating
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $status
 *
 * @package App\Models
 */
class DMReview extends Model
{
	protected $table = 'd_m_reviews';

	protected $casts = [
		'delivery_man_id' => 'int',
		'user_id' => 'int',
		'order_id' => 'int',
		'rating' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'delivery_man_id',
		'user_id',
		'order_id',
		'comment',
		'attachment',
		'rating',
		'status'
	];
}
