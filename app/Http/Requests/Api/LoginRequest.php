<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class LoginRequest extends FormRequest
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
            'phone'=>'required',
            'password'=>'required|min:6'

        ];
    }


    public function failedValidation (Validator $validator){
        //  $ee=$validator->errors();
        // print_r($ee['messages']); exit;
        $ee=$validator->errors();

        $errors=array();
        foreach($ee->messages() as $error){

            $errors['descreption'][]=$error[0];
        }

        throw new HttpResponseException(



            response()->json([
                'status'=>false,

                'errors' =>$errors,
                'message' =>HTTPResponseCodes::Validation['message'],
                'code'=>HTTPResponseCodes::Validation['code']
            ],HTTPResponseCodes::Validation['code']));
    }

    public function messages(){

        return[
            'phone.required'=>__('phone is reuired'),
            'password.required'=>__('password is required'),
            'password.min'=>__('password must more than 6 digits')
        ];
    }
}
