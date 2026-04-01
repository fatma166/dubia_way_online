<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class CategoryRequest extends FormRequest
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
       /* $data= request()->all();
        $vendor_id=$data['vendor_id'];
        $id=$data['id'];*/
        return [
            'name' => 'required',
        ];

    }

    /**
     * Custom message for validation
     *
     * @return array
     */
   /* public function messages()
    {
        return [
            'name.required'=>trans('name is required')

        ];
    }*/
    public function attributes()
    {
        return [
            'name' => __('name'),
            // Add more attribute translations
        ];
    }

}
