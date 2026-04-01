<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class PlaceEditRequest extends FormRequest
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
        $data= request()->all();
       $vendor_id=$data['vendor_id'];
       $id=$data['id'];
        return [
            'name' => 'required',
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
            'phone' => 'required|unique:vendors,phone,'.$vendor_id.',id,deleted_at,NULL',
            'email'=> 'required|email|unique:vendors,email,'.$vendor_id.',id,deleted_at,NULL',
            'image'=>'sometimes|required|array',
           'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'cover_photo'=>'sometimes|required|array',
           'cover_photo.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'password' => 'nullable|min:6|required_with:confirm_password|same:confirm_password',
          'confirm_password' => 'nullable|min:6',
          'delivery_time_unit'=>'required'
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
            'delivery_charge' => __('delivery_charge'),
            'minimum_order'=>__('minimum_order'),
            'delivery charge' => __('delivery charge'),
            'compilation_id' => __('compilation_id'),
            'opening_time' => __('opening_time'),
            'closeing_time' => __('closeing_time'),
            'delivery_time_from' => __('delivery_time_from'),
            'delivery_time_to' => __('delivery_time_to'),
            'zone_id' => __('zone_id'),
            'latitude' => __('latitude'),
            'longitude' => __('longitude'),
            'f_name' => __('f_name'),
            'l_name' => __('l_name'),
            'phone' => __('phone'),
            'email' => __('email'),
            'image' => __('image'),
            'cover_photo' => __('cover_photo'),
            'password' => __('password'),
            'confirm_password' => __('confirm_password'),
             'delivery_time_unit'=>__('delivery_time_unit')
        ];
    }



}
