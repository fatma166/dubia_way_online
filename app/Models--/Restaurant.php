<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Scopes\ZoneScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Restaurant
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string|null $logo
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $address
 * @property string|null $footer_text
 * @property float $minimum_order
 * @property float|null $comission
 * @property Carbon|null $opening_time
 * @property Carbon|null $closeing_time
 * @property bool $free_delivery
 * @property bool $status
 * @property int $vendor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $rating
 * @property string|null $cover_photo
 * @property bool $delivery
 * @property bool $take_away
 * @property bool $schedule_order
 * @property bool $food_section
 * @property float $tax
 * @property int|null $zone_id
 * @property bool $reviews_section
 * @property bool $active
 * @property string $off_day
 * @property string|null $gst
 * @property bool $self_delivery_system
 * @property bool $pos_system
 * @property float $delivery_charge
 * @property string|null $delivery_time
 * @property bool $veg
 * @property bool $non_veg
 * @property int $order_count
 * @property float $minimum_shipping_charge
 * @property float $per_km_shipping_charge
 *
 * @package App\Models
 */
class Restaurant extends Model
{
    use SoftDeletes;
	protected $table = 'restaurants';

	protected $casts = [
		'minimum_order' => 'float',
		'comission' => 'float',
		'opening_time' => 'datetime',
		'closeing_time' => 'datetime',
		'free_delivery' => 'bool',
		'status' => 'bool',
		'vendor_id' => 'int',
		'delivery' => 'bool',
		'take_away' => 'bool',
		'schedule_order' => 'bool',
		'food_section' => 'bool',
		'tax' => 'float',
		'zone_id' => 'int',
		'reviews_section' => 'bool',
		'active' => 'bool',
		'self_delivery_system' => 'bool',
		'pos_system' => 'bool',
		'delivery_charge' => 'float',
		'veg' => 'bool',
		'non_veg' => 'bool',
		'order_count' => 'int',
		'minimum_shipping_charge' => 'float',
		'per_km_shipping_charge' => 'float'
	];

	protected $fillable = [
		'name',
		'phone',
		'email',
		'logo',
		'latitude',
		'longitude',
		'address',
		'footer_text',
		'minimum_order',
		'comission',
		'opening_time',
		'closeing_time',
		'free_delivery',
		'status',
        'compilation_id',
		'vendor_id',
		'rating',
		'cover_photo',
		'delivery',
		'take_away',
		'schedule_order',
		'food_section',
		'tax',
		'zone_id',
		'reviews_section',
		'active',
		'off_day',
		'gst',
		'self_delivery_system',
		'pos_system',
		'delivery_charge',
		'delivery_time',
		'veg',
		'non_veg',
		'order_count',
		'minimum_shipping_charge',
		'per_km_shipping_charge'
	];
    protected $appends = ['gst_status','gst_code','logo_url','cover_photo_url'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'gst'
    ];

    public function getLogoUrlAttribute()
    {
        return asset($this->logo);
    }
    public function getCoverPhotoUrlAttribute()
    {
        return asset($this->cover_photo);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function schedules()
    {
        return $this->hasMany(RestaurantSchedule::class)->orderBy('opening_time');
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function compilation()
    {
        return $this->hasOne(Compilation::class,'id','compilation_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }



    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Food::class);
    }

   /* public function getScheduleOrderAttribute($value)
    {
        return (boolean)(\App\CentralLogics\Helpers::schedule_order()?$value:0);
    }*/
    public function getRatingAttribute($value)
    {
        $ratings = json_decode($value, true);
        $rating5 = $ratings?$ratings[5]:0;
        $rating4 = $ratings?$ratings[4]:0;
        $rating3 = $ratings?$ratings[3]:0;
        $rating2 = $ratings?$ratings[2]:0;
        $rating1 = $ratings?$ratings[1]:0;
        return [$rating5, $rating4, $rating3, $rating2, $rating1];
    }

    public function getGstStatusAttribute()
    {
        return (boolean)($this->gst?json_decode($this->gst, true)['status']:0);
    }

    public function getGstCodeAttribute()
    {
        return (string)($this->gst?json_decode($this->gst, true)['code']:'');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOpened($query)
    {
        return $query->where('active', 1);
    }

    public function scopeWithOpen($query)
    {
        $query->selectRaw('*, IF(((select count(*) from `restaurant_schedule` where `restaurants`.`id` = `restaurant_schedule`.`restaurant_id` and `restaurant_schedule`.`day` = '.now()->dayOfWeek.' and `restaurant_schedule`.`opening_time` < "'.now()->format('H:i:s').'" and `restaurant_schedule`.`closing_time` >"'.now()->format('H:i:s').'") > 0), true, false) as open');
    }
    public function scopeWithLocation($query,$location){
        $sqlDistance = DB::raw('( 111.045 * acos( cos( radians(' . $location['lat'] . ') ) * cos( radians( restaurants.latitude ) ) 
* cos( radians( restaurants.longitude ) - radians(' . $location['lng']  . ') ) 
+ sin( radians(' . $location['lat']  . ') ) * sin( radians( restaurants.latitude ) ) ) )');
        $allow=config('allow_distance');
     return   $query->selectRaw(" {$sqlDistance} AS distance")->havingRaw("distance <= 10");
    }



    public function scopeWeekday($query)
    {
        return $query->where('off_day', 'not like', "%".now()->dayOfWeek."%");
    }

   /* protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }*/

    public function scopeType($query, $type)
    {
        if($type == 'veg')
        {
            return $query->where('veg', true);
        }
        else if($type == 'non_veg')
        {
            return $query->where('non_veg', true);
        }

        return $query;

    }
}
