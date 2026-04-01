<?php
namespace App\Http\Controllers\Api\V1\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\VerifyRequest;
use App\Modules\Core\HTTPResponseCodes;
use App\Http\Resources\UserResource;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Exception;
class AuthUserController extends Controller
{
    public function checkLogin(){
        return response()->json([
            'status' =>HTTPResponseCodes::Sucess['status'],
            'message' => HTTPResponseCodes::Sucess['message'],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }

    public function login(LoginRequest $request){

        /*  $req = Validator::make($request->all(), [

                              'phone'=>'required',
                              'password'=>'required|min:6'


          ]);
          if($req->fails()){
            //  return($req->messages());
            return response()->json([
              'status' =>HTTPResponseCodes::Validation['status'],
              'data' =>$req->messages(),
              'message' =>HTTPResponseCodes::Validation['message'],
              ],HTTPResponseCodes::Validation['code']);
          }*/

        $validated=$request->all();


        //  $user = customer::where('phone', $validated['phone'])->first();


        if (!Auth::guard('api')->attempt($validated)) {

            return response()->json([
                'status' =>HTTPResponseCodes::UnAuth['status'],

                'errors'=>[],
                'message' => HTTPResponseCodes::UnAuth['message'],
                'code'=>HTTPResponseCodes::UnAuth['code']
            ],HTTPResponseCodes::Sucess['code']);
        }


        // if (Hash::check($request->password, $user->password)) {
        $user = Auth::guard('api')->user();
        $token = Auth::guard('api')->attempt($validated);
        //  $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $user['token']= $token;

        return response()->json([
            'status' =>HTTPResponseCodes::Sucess['status'],
            'data' => new UserResource($user),
            'errors'=>[],
            'message'=> HTTPResponseCodes::Sucess['message'],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
        return response($response, 200);
        // } else {
        /* return response()->json([
             'status' =>HTTPResponseCodes::UnAuth['status'],

             'errors'=>[],
             'message' => HTTPResponseCodes::UnAuth['message'],
             'code'=>HTTPResponseCodes::UnAuth['code']
         ],HTTPResponseCodes::Sucess['code']);
     }*/
        //$user['expired']= auth('api')->factory()->getTTL()*60;

    }
    /**
     *
     *
     */
    public function register(RegisterRequest $request) {

        /* $req= Validator::make($request->all(), [
             'name' => 'required|min:4',
             'last_name' => 'required|min:4',
             'phone' => 'required|unique:users|min:5',
             'password' => 'required|min:6',
             'birth_date' => 'required|date',
             'role_id'   => 'required']
             );

             if($req->fails()){
                 return response()->json([
                                             'status' =>HTTPResponseCodes::UnAuth['status'],
                                             'data' =>[],
                                             'errors'=>[],
                                             'message' => HTTPResponseCodes::UnAuth['message'],
                     ],HTTPResponseCodes::UnAuth['code']);
             }*/
        $validated = $request->all();
        $validated ['active']=0;
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");


        $twilio = new Client($twilio_sid, $token);

        try{
            $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($validated['phone'], "sms");

        }catch(\Exception $e){

            return response()->json(
                [
                    'status' => HTTPResponseCodes::BadRequest['status'],
                    'message' => HTTPResponseCodes::BadRequest['message'],
                    'errors' =>__("phone number is not valid"),
                    'data' => [],
                    'code'=>HTTPResponseCodes::BadRequest['code']
                ]);


        }
        $validated['password']= Hash::make($validated['password']);
        try{
            $user= User::create($validated);

        }catch(\Exception $e){
            return response()->json(
                [
                    'status' => HTTPResponseCodes::BadRequest['status'],
                    'message' => HTTPResponseCodes::BadRequest['message'],
                    'errors' => [],
                    'data' => [],
                    'code'=>HTTPResponseCodes::BadRequest['code']
                ]);


        }
        return response()->json(
            [
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => [],
                'code'=>HTTPResponseCodes::Sucess['code']
                //'token' => $token,
            ],HTTPResponseCodes::Sucess['code']);


        //$token = Auth::login($user);

        //return redirect()->route('verify')->with(['phone' => $validated['phone']]);

    }

    /**
     *
     */
    protected function verify(VerifyRequest $request)
    {

        /* $data = $request->validate([
             'verification_code' => ['required', 'numeric'],
             'phone' => ['required', 'string'],
         ]);*/


        try{
            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);

            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(['to'=>$request['phone'],'code'=>$request['verification_code']]);


            if ($verification->valid) {


                $user = tap(User::where('phone', $request['phone']))->update(['is_phone_verified' => true,'active'=>1]);
                $data=$user->first();
//print_r($user->first());exit;
                //  $user->token=$token;
                /* Authenticate user */
                // $user=$user->first();
                //   $validate= new LoginRequest() ;

                //    $request1= $user->validate($validate->rules());
                //   return( $this->login($request1));

                //  Auth::login($user->first());
                // $data=Auth::user();
                // $data['token']=Auth::fromUser($data);
                //  print_r($data); exit;
                return response()->json([
                    'status' => HTTPResponseCodes::Sucess['status'],
                    'message' => HTTPResponseCodes::Sucess['message'],
                    'errors' => [],
                    'data' => new UserResource($data),
                    'code'=>HTTPResponseCodes::Sucess['code']

                ],HTTPResponseCodes::Sucess['code']);
            }
        }catch(\Exception $e){

            if($e->getCode()==404||$e->getCode()==20404){
                //  User::where('phone', $request['phone'])->update(['is_phone_verified' => true,'active'=>1]);
                return response()->json([
                    'status' =>HTTPResponseCodes::InvalidArguments['status'],
                    'message' => HTTPResponseCodes::InvalidArguments['message'],
                    'errors' => [],

                    'code'=>HTTPResponseCodes::InvalidArguments['code']
                ],HTTPResponseCodes::Sucess['code']);
            }
        }

        /* return response()->json([
                                 'status' => HTTPResponseCodes::BadRequest['status'],
                                 'message' => HTTPResponseCodes::BadRequest['message'],
                                 'errors' => [],

                                 'code'=>  HTTPResponseCodes::BadRequest['code']
               ]);//, HTTPResponseCodes::BadRequest['code']*/
        // return redirect()->route('home')->with(['message' => 'Phone number verified']);

        /* ;*/
        //  return back()->with(['phone' => $data['phone'], 'error' => 'Invalid verification code entered!']);
    }
    /**
     *
     */
    public function logout()
    {

        $ee=  Auth::logout();

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message' =>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data'=>[],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
    /**
     *
     */
    public function refresh()
    {
        $user=Auth::user();
        $user['token']=Auth::refresh();
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'data' => new UserResource($user),
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
    /**
     *
     */
    public function get_roles(){

        $data=Role::all();

        return response()->json([
            'status' =>HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => RoleResource::collection($data),
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);
    }
    /**
     *
     */
    public function get_countries(Request $request,$id){

        $data_request=$request->all();

        // $id=$data_request['id']??null;
        //print_r(Country::find(1)->country_translations); exit;

        if($id){

            $data=Country::where('id',$id)->first();

            if($data!=null)
                return response()->json([
                    'status' => HTTPResponseCodes::Sucess['status'],
                    'message'=>HTTPResponseCodes::Sucess['message'],
                    'errors' => [],
                    'data' =>new CountryResource($data),
                    'code'=>HTTPResponseCodes::Sucess['code']
                ],HTTPResponseCodes::Sucess['code']);
        }else{

            $data=Country::/*with('country_translations')->*/get();

            if($data!=null)
                return response()->json([
                    'status' => HTTPResponseCodes::Sucess['status'],
                    'message'=>HTTPResponseCodes::Sucess['message'],
                    'errors' => [],
                    'data' =>CountryResource::collection($data),
                    'code'=>HTTPResponseCodes::Sucess['code']
                ],HTTPResponseCodes::Sucess['code']);
        }

        return response()->json([
            'status' => HTTPResponseCodes::BadRequest['status'],
            'message'=>HTTPResponseCodes::BadRequest['message'],
            'errors' => [],

            'code'=>HTTPResponseCodes::BadRequest['code']
        ],HTTPResponseCodes::BadRequest['code']);
    }

    /**
     *
     */
    public function forgetPassword(Request $request){

        $phoneNum =$request['phone'];

        $user = User::where('phone', '=', $phoneNum)->firstOrFail();
        if($user)
        {
            Session::put('phone',$phoneNum);

            $user->sendToken();
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => new UserResource($user),
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);

        } else
        {
            return response()->json([
                'status' => HTTPResponseCodes::BadRequest['status'],
                'message'=>HTTPResponseCodes::BadRequest['message'],
                'errors' => [],

                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::BadRequest['code']);

        }

    }
    /**
     *
     */
    public function validatePassowrd(Request $request){

        $req=Validator::make($request->all(),['token'=>'required','password'=>'required|min:6',
            'confirmpass'=>'required|same:password']);
        if($req->fails()){
            return response()->json([
                'status' => HTTPResponseCodes::UnAuth['status'],
                'message'=>HTTPResponseCodes::UnAuth['message'],
                'errors' => [],

                'code'=>HTTPResponseCodes::UnAuth['code']
            ],HTTPResponseCodes::UnAuth['code']);
        }
        $token=$request['token'];
        $newpassword=$request['password'];

        $phoneNum=Session::get('phone');

        $user = User::where('phone', '=', $phoneNum)->firstOrFail();

        if($user && $user->validateToken($token)) {
            try{
                $this->changePassword($phoneNum,$newpassword);
            }catch(\Exception $e){
                return response()->json([
                    'status' => HTTPResponseCodes::BadRequest['status'],
                    'message'=>HTTPResponseCodes::BadRequest['message'],
                    'errors' =>[],

                    'code'=>HTTPResponseCodes::BadRequest['code']
                ],HTTPResponseCodes::BadRequest['code']);
            }
            return  response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message'=>HTTPResponseCodes::Sucess['status'],
                'errors' => [],
                'data' => $user,
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);

        } else
        {
            return response()->json([
                'status'=> HTTPResponseCodes::BadRequest['status'],
                'message'=>HTTPResponseCodes::BadRequest['message'],
                'errors' => [],

                'code'=>HTTPResponseCodes::BadRequest['code']
            ],HTTPResponseCodes::BadRequest['code']);

        }
    }
    /**
     *
     */
    protected function changePassword($phone,$newpassword){
        User::where('phone_number', '=', $phoneNum)->update(array('password'=>Hash::make($newpassword)));
    }

    /**
     *
     */
    protected function getData(){

        $user= Auth::user();
        if($user!=null) {
            return response()->json([
                'status' => HTTPResponseCodes::Sucess['status'],
                'message' => HTTPResponseCodes::Sucess['message'],
                'errors' => [],
                'data' => new UserResource($user), //UserCollection::collection($user),
                'code' => HTTPResponseCodes::Sucess['code']
            ], HTTPResponseCodes::Sucess['code']);
        }
        return response()->json([
            'status'=> HTTPResponseCodes::BadRequest['status'],
            'message'=>HTTPResponseCodes::BadRequest['message'],
            'errors' => [],

            'code'=>HTTPResponseCodes::BadRequest['code']
        ],HTTPResponseCodes::BadRequest['code']);
    }

    public function store_device_token(Request $request){

        $token_db= User::where('id',auth::user()->id)->value('device_token');
        if(is_null($token_db)){
            user::where('id',auth::user()->id)->update(['device_token'=>$request['token']]);
        }
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message' => HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' =>[], //UserCollection::collection($user),
            'code' => HTTPResponseCodes::Sucess['code']
        ], HTTPResponseCodes::Sucess['code']);
    }
     public function updateDeviceToken(Request $request)
    {
        Auth::user()->cm_firebase_token =  $request->token;

        Auth::user()->save();
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message' => __('Token successfully stored.'),
            'errors' => [],
            'data' =>[], //UserCollection::collection($user),
            'code' => HTTPResponseCodes::Sucess['code']
        ], HTTPResponseCodes::Sucess['code']);

    }
}
