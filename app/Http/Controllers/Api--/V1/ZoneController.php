<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Resources\Api\ZoneResource;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use App\Modules\Core\HTTPResponseCodes;
use App\Traits\LocationTrait;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    use LocationTrait;

    public function get_zones(Request $request)
    {


        //$data=[{"latitude":'30.5744821',"longitude":'31.0146668'}];
        $data=array('latitude'=>$request->lati,'longitude'=>$request->longi);

        $data= $this->get_zone_from_location($data);
       // Helper::address_data_formatting($request->all());

        $data= Zone::where('status',1)->whereIn('id',$data)->get();

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' =>ZoneResource::collection($data),
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
}
