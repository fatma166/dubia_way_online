<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class OrderRequest extends FormRequest
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

            'order_amount' => 'required',
           // 'payment_method'=>'required|in:cash_on_delivery,digital_payment,wallet',
            'restaurant_id' => 'required',
            'address' => 'required_if:address_id,null',
            'address_id'=>'required_if:address,null',
            'longi' => 'required',
            'lati' => 'required',
             'cart_items'=>'required'


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
            'order_amount.required' => __('order_amount is required'),
            // 'payment_method.required'=>__('payment_method is required'),
            'restaurant_id.required' => __('restaurant_id is required'),
            'address.required_if' => __('address is required'),
            'address_id.required_if' => __('address is required'),
            'longi.required' => __('longitude is required'),
            'lati.required' => __(' latitude is required'),
            'cart_items.required'=>__(' cart items required')

        ];
    }

}
