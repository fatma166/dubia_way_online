<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class PlaceRequest extends FormRequest
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
            'name' => 'required|unique:restaurants',
            'footer_text' => 'required',
            'address' => 'required',
            'delivery_charge' => 'required|numeric',
            'minimum_order'=>'required|numeric',
            'compilation_id' => 'required|numeric|exists:compilations,id',
            'opening_time' => 'required',
            'closeing_time' => 'required',
            'delivery_time_from' => 'required',
            'delivery_time_to' => 'required',
            'zone_id' => 'required|numeric|exists:zones,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required|unique:restaurants',
            'email' => 'required|unique:restaurants',
            'image'=>'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_photo'=>'required|array',
            'cover_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ];

    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('name'),
            'footer_text' => __('footer_text'),
            'address' => __('address'),
            'delivery_charge' => __('delivery charge'),
              'minimum_order'=>__('minimum_order'),
            'compilation_id' => __('compilation_id'),
            'opening_time' => __('opening_time'),
            'closeing_time' => __('closeing_time'),
            'delivery_time_from' =>__( 'delivery_time_from'),
            'delivery_time_to' => __('delivery_time_to'),
            'zone_id' =>__( 'zone_id'),
            'latitude' => __('latitude'),
            'longitude' => __('longitude'),
            'f_name' => __('f_name'),
            'l_name' =>__('l_name'),
            'phone' => __('phone'),
            'email' => __('email'),
            'image'=>__('image'),
            'cover_photo'=>__('cover_photo'),
            'password' => __('password'),
            'confirm_password' =>__( 'confirm_password')
        ];
    }


}
