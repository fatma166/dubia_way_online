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
class FavFood extends Model
{
	protected $table = 'fav_foods';



	protected $fillable = [

		'user_id',
        'food_id',
	];
    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
