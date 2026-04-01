<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class SingleFoodRequest extends FormRequest
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
            'food_id' => 'required',
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
            'id.required' => __('food_id is required'),

        ];
    }

}
