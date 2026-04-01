<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\BannerRepositories;
use Illuminate\Http\Request;
use App\Traits\LocationTrait;

class BannerController extends Controller
{
    //
    use LocationTrait;
    public function get_banner(Request $request){

       $data= $request->all();
        if((!$request->filled('lati')&& !$request->filled(('longi'))) && ((!$request->filled('zone_id'))||empty($request['zone_id'])))

            return     response()->json([
                'status' =>false,
                'errors'=>__('must choose location'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
      // if($request->filled('lati')&&$request->filled(('longi')))
        if((!$request->filled('zone_id')) && !empty($request['zone_id'])) {
            $zone_ids=array($request['zone_id']);
        }else{
            $data=array('latitude'=>$request['lati'],'longitude'=>$request['longi']);
            $zone_ids= $this->get_zone_from_location($data);

            if(count($zone_ids)==0)
                return     response()->json([
                    'status' =>false,
                    'errors'=>__('no zone match app not work in this zone'),
                    'message' =>HTTPResponseCodes::BadRequest['message'],
                    'code'=>HTTPResponseCodes::BadRequest['code']
                ],HTTPResponseCodes::Sucess['code']);

        }

          $banner = new BannerRepositories();

          $banners = $banner->get_banner($zone_ids);

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' =>$banners,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);




    }


}
