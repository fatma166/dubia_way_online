<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
     $id= request()->route('notification');

        if(!isset($id)) {
            return [
                'title' => 'required',
                'image' => 'required',
                //  'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
               // 'zone_id' => 'required|numeric|exists:zones,id',
                'description' => 'required',
            ];
        }else{

                        return [
                            'title' => 'required',
                            'image'=>'required_if:old_image,null',
                          //  'zone_id' => 'required|numeric|exists:zones,id',
                            'description' => 'required',
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
               'description'=>__('description')
        ];
    }


}
