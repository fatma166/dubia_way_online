<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompilationRequest extends FormRequest
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
                'title' => 'required',
                'description' => 'required',
                'image'=>'required',
            ];
        }else{
            return [
                'title' => 'required',
                'description' => 'required',
                'image'=>'required_if:old_image,null',

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
               'description'=>__('description'),
               'image'=>__('image'),

        ];
    }


}
