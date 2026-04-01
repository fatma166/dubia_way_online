<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class UpdateAddressRequest extends FormRequest
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
            'address_id'=>'required',
           /* 'address' => 'required|nullable',
            'floor'=>'required|nullable',
            'contact_person_number' => 'required',
            'road' => 'required',
            'house' => 'required|nullable',*/
            'lati' => 'required',
            'longi'=>'required',


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
            'id.required' => __('category_id is required'),

        ];
        return [
            'address_id.required' => __('address_id is required'),
          /*  'contact_person_number.required' => __('contact_person_number is required'),
            'road.required'=>__('road is required'),
            'house.required' => __(' house is required'),
            'address.required' => __('address is required'),
            'floor.required' => __('floor is required'),*/
            'lati.required' => __('latitudeis required'),
            'longi.required' => __('  longitude is required'),

        ];
    }

}
