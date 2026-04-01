<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $food_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $restaurant_id
 *
 * @package App\Models
 */
class Wishlist extends Model
{
	protected $table = 'wishlists';

	protected $casts = [
		'user_id' => 'int',
		'food_id' => 'int',
		'restaurant_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'food_id',
		'restaurant_id'
	];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
