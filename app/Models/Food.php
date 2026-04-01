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
 * Class Food
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $image
 * @property int|null $category_id
 * @property string|null $category_ids
 * @property string|null $variations
 * @property string|null $add_ons
 * @property string|null $attributes
 * @property string|null $choice_options
 * @property float $price
 * @property float $tax
 * @property string $tax_type
 * @property float $discount
 * @property string $discount_type
 * @property Carbon|null $available_time_starts
 * @property Carbon|null $available_time_ends
 * @property bool $veg
 * @property bool $status
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_count
 * @property float $avg_rating
 * @property int $rating_count
 * @property string|null $rating
 *
 * @package App\Models
 */
class Food extends Model
{
    protected $table = 'food';

    protected $casts = [
        'category_id' => 'int',
        'price' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'available_time_starts' => 'datetime',
        'available_time_ends' => 'datetime',
        'veg' => 'bool',
        'status' => 'bool',
        'restaurant_id' => 'int',
        'order_count' => 'int',
        'avg_rating' => 'float',
        'rating_count' => 'int',

    ];

    protected $fillable = [
        'name',
        'description',
        'summary',
        'image',
        'category_id',
        'category_ids',
        'variations',
        'add_ons',
        'attributes',
        'choice_options',
        'price',
        'tax',
        'tax_type',
        'discount',
        'discount_type',
        'available_time_starts',
        'available_time_ends',
        'veg',
        'status',
        'restaurant_id',
        'order_count',
        'avg_rating',
        'rating_count',
        'rating',
        'in_stock',
        'favourite',
		'slider_status',
        'product_quantity'
    ];

    protected $appends = ['image_url'];

    public function getRateDataAttribute()
    {
        // echo"jkjk"; exit;
        $data = Helper::calculate_restaurant_rating($this->rating);
        return $data['rating'];
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image);//'images/product/'.
    }

    public function scopeActive($query)
    {
        //->where('status', 1)
        //    return $query->whereHas('restaurant', function ($query) {
        return $query->where('status', 1);
        // });
    }

    public function scopeAvailable($query, $time)
    {
        $query->where(function ($q) use ($time) {
            $q->where('available_time_starts', '<=', $time)->where('available_time_ends', '>=', $time);
        });
    }

    public function scopePopular($query)
    {
        return $query->orderBy('order_count', 'desc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function slider()
    {
        return $this->hasMany(Food_slider_image::class);
    }
      public function favfood()
    {
        return $this->hasMany(FavFood::class);
    }

    // public function rating()
    // {
    //     return $this->hasMany(Review::class)
    //         ->select(DB::raw('avg(rating) average, count(food_id) rating_count, food_id'))
    //         ->groupBy('food_id');
    // }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function getCategoryAttribute()
    {
        $category = Category::find(json_decode($this->category_ids)[0]->id);
        return $category ? $category->name : trans('messages.uncategorize');
    }

    protected static function booted()
    {
        if (auth('vendor')->check() || auth('vendor_employee')->check()) {
            static::addGlobalScope(new RestaurantScope);
        }

        static::addGlobalScope(new ZoneScope);

    }


    public function scopeType($query, $type)
    {
        if ($type == 'veg') {
            return $query->where('veg', true);
        } else if ($type == 'non_veg') {
            return $query->where('veg', false);
        }

        return $query;
    }

    public function scopeRate($query)
    {
        //return $query->selectRaw('JSON_EXTRACT(rating, "$.*") as data'); exit;
        return $query->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(rating, "$[5]")) DESC');
        //->get();
        // print_r($highestRate); exit;

    }
}
