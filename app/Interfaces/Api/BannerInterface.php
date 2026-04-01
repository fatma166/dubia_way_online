<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface  BannerInterface
{

    public function get_banner($zone_ids,$module_place,$type) ;


}
