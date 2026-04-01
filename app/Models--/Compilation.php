<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Compilation extends Model
{
    protected $table = 'compilations';

    protected $casts = [
        'parent_id' => 'int',
        'position' => 'int',
        'status' => 'bool',
        'priority'=>'int'

    ];
    public $appends = [ 'image_url'];

    protected $fillable = [
        'title',
        'image',
        'parent_id',
        'position',
        'status',
        'priority',
        'description'

    ];
    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }

    public function compilaionRestaurant(){
        return $this->hasMany(Restaurant::class, 'compilaion_id');
    }

}
