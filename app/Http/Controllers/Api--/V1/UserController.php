<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressRequest;
use App\Http\Requests\Api\DeleteAddressRequest;
use App\Http\Requests\Api\UpdateAddressRequest;
use App\Modules\Core\HTTPResponseCodes;
use App\Repositories\Api\UserRepository;
use App\Traits\LocationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use LocationTrait;
    public function add_new_address(AddressRequest $request)
    {
        $data = array('latitude' => $request['lati'], 'longitude' => $request['longi']);
        $zone_ids = $this->get_zone_from_location($data);

        if(count($zone_ids) == 0)
        {

            return response()->json([
                'status' => false,
                'errors' => __('service_not_available_in_this_area'),
                'message' => __('service_not_available_in_this_area'),
                'code' => HTTPResponseCodes::InvalidArguments['code']
            ], HTTPResponseCodes::Sucess['code']);
        }
       // try{
            $userobj=new UserRepository();
            $userobj->add_new_address($request,$zone_ids,'add');
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' =>[],
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);
       /* } catch (\Exception $e) {
            return response()->json([
            'status' =>false,
            'errors'=>__('error when retrieve data'),
            'message' =>HTTPResponseCodes::BadRequest['message'],
            'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::Sucess['code']);
        }*/

    }

    public function update_address(UpdateAddressRequest $request ){
        $data = ['latitude' => $request['lati'], 'longitude' => $request['longi']];
        $zone_ids = $this->get_zone_from_location($data);
        if(count($zone_ids) == 0)
        {

            return response()->json([
                'status' => false,
                'errors' => __('service_not_available_in_this_area'),
                'message' => __('service_not_available_in_this_area'),
                'code' => HTTPResponseCodes::InvalidArguments['code']
            ], HTTPResponseCodes::Sucess['code']);
        }
      try {
          $update_obj = new UserRepository();
          $update_obj->add_new_address($request, $zone_ids,'update');
          return response()->json([
              'status' => HTTPResponseCodes::Sucess['status'],
              'message' => HTTPResponseCodes::Sucess['message'],
              'errors' => [],
              'data' => [],
              'code' => HTTPResponseCodes::Sucess['code']
          ], HTTPResponseCodes::Sucess['code']);
      } catch (\Exception $e) {
          return response()->json([
              'status' =>false,
              'errors'=>__('error when retrieve data'),
              'message' =>HTTPResponseCodes::BadRequest['message'],
              'code'=>HTTPResponseCodes::BadRequest['code']
          ],HTTPResponseCodes::Sucess['code']);
      }


    }
    public function delete_address(DeleteAddressRequest $request){
       try{
            $delete_obj=new UserRepository();
           $result= $delete_obj->delete_address($request->address_id);
           if($result==true){
               return response()->json([
                   'status' => HTTPResponseCodes::Sucess['status'],
                   'message' => HTTPResponseCodes::Sucess['message'],
                   'errors' => [],
                   'data' => [],
                   'code' => HTTPResponseCodes::Sucess['code']
               ], HTTPResponseCodes::Sucess['code']);
           }else{
               return response()->json([
                   'status' =>false,
                   'errors'=>__('error when retrieve data'),
                   'message' =>HTTPResponseCodes::BadRequest['message'],
                   'code'=>HTTPResponseCodes::BadRequest['code']
               ],HTTPResponseCodes::Sucess['code']);
           }
       } catch (\Exception $e) {
           return response()->json([
               'status' =>false,
               'errors'=>__('error when retrieve data'),
               'message' =>HTTPResponseCodes::BadRequest['message'],
               'code'=>HTTPResponseCodes::BadRequest['code']
           ],HTTPResponseCodes::Sucess['code']);
       }

    }

    public function info(Request $request){
        try {


            $user_obj = new UserRepository();
            $user_info = $user_obj->info($request);
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' =>$user_info,
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
        } catch (\Exception $e) {
                return response()->json([
                'status' =>false,
                'errors'=>__('error when retrieve data'),
                'message' =>HTTPResponseCodes::BadRequest['message'],
                'code'=>HTTPResponseCodes::BadRequest['code']
                ],HTTPResponseCodes::Sucess['code']);
        }


    }

}
