<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
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
      $id= request()->route('id');

        if(!isset($id)){
            return [
                'name' => 'required|unique:zones',
                'coordinates'=>'required',

            ];
       }else{
            return [
            'name' => 'required|unique:zones,name,'.$id,
                'coordinates'=>'required'
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
               'name'=>__('name'),
               'coordinates'=>__('coordinates'),

        ];
    }


}
