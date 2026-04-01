<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GetCountryResource;
use App\Http\Resources\Api\GetCurrencyResource;
use App\Models\BusinessSetting;
use App\Modules\Core\HTTPResponseCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessSettingController extends Controller
{
    //

    public function get_defaultcountry(){
        $data=DB::table('business_settings')->where('key','default_country')->join('country','business_settings.value','=','country.code2')->select('country.*')->get();
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => GetCountryResource::collection($data),
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);

    }

    public function get_currency(){
        $data=DB::table('business_settings')->where('key','currency')->join('currencies','business_settings.value','=','currencies.currency_code')->select('currencies.*')->get();

        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => GetCurrencyResource::collection($data),
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);

    }
}
