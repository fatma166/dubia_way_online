<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface  UseInterface
{

    public function Add_new_address($request,$zone_ids,$type) ;
    public function delete_address($address_id);
    public function info($request);



}
