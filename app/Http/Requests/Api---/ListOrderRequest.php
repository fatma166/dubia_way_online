<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class ListOrderRequest extends FormRequest
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
          //  'name' => 'required|min:4|nullable',
            'limit' => 'required',
            'offset'=>'required',
            'current_order'=>'required_without:latest_order',
            'latest_order'=>'required_without:current_order',
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
            'offset.required' => __('offset is required'),

            'current_order.required_without' => __('current_order is required with out last_order'),
            'current_order.boolean' => __('current_order is boolean'),
            'latest_order.required_without' => __('current_order is required with out current_order'),
            'latest_order.boolean' => __('current_order is boolean'),

        ];
    }

}
