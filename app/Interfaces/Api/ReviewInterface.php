<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface  ReviewInterface
{

    public function review($restaurant_id) ;
    public function add_restaurant_review($request);
    public function get_restaurant_review($request);



}
