<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class LatestRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'offset' => 'required|nullable',
            'limit' => 'required',
            'zone_id'=>'required_if:longi,null',
            'longi' => 'required_if:zone_id,null',
            'lati' => 'required_if:zone_id,null',
            'compilation_id'=>'required'



        ];

    }

    public function failedValidation(Validator $validator){
        $ee=$validator->errors();

        $errors=array();
        foreach($ee->messages() as $error){

            $errors['descreption'][]=$error[0];
        }

        throw new HttpResponseException(


            response()->json([
                'status' =>false,

                'errors'=>$errors,
                'message' =>HTTPResponseCodes::Validation['message'],
                'code'=>HTTPResponseCodes::Validation['code']
            ],HTTPResponseCodes::Sucess['code']));



    }

    public function messages(){
        return[
            'limit.required' => __('limit is required'),
            'zone_id.required_if' => __('zone_id or location is required'),
            'longi.required_if' => __('longitude is required whem zone is null'),
            'lati.required_if' => __(' latitude is required is required whem zone is null'),

        ];
    }

}
