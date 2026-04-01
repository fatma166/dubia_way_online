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
class Food_slider_image extends Model
{
	protected $table = 'food_slider_images';



	protected $fillable = [
		'food_id',
		'image',

	];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }




}
