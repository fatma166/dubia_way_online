<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface  FoodInterface
{

    public function get_food($zone_ids,$restaurant_id,$category_ids,$limit,$offset,$location,$filter_data);
    public function single_food($food_id,$related_limit);
    public function get_popular($filter_data, $limit , $offset,$paginate);
    public function get_latest($filter_data, $limit , $offset,$paginate);
    public function list_food($filter_data, $limit, $offset, $paginate);





}
