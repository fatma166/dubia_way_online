<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
      $id= request()->route('banner');

        if(!isset($id)){
            return [
                'title' => 'required',
                'image'=>'required',
                //  'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'zone_id' => 'required|numeric|exists:zones,id',
                'compilation_id' => 'required|numeric|exists:compilations,id',
                'place_id' => 'required|numeric|exists:restaurants,id',
            ];
        }else{
            return [
                'title' => 'required',
                'image'=>'required_if:old_image,null',
                //  'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'zone_id' => 'required|numeric|exists:zones,id',
                'compilation_id' => 'required|numeric|exists:compilations,id',
                'place_id' => 'required|numeric|exists:restaurants,id',
            ];
        }


    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function attributes()
    {
        return [
               'title'=>__('title'),
               'image'=>__('image'),
               'zone_id'=>__('zone_id'),
               'compilation_id'=>__('compilation_id'),
               'place_id'=>__('place_id'),
               'old_image'=>__('old_image')
        ];
    }


}
