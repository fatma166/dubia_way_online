<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class AdminEmployeeRequest extends FormRequest
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
        $id=request()->route('id');

        if($id!=""){

            return [
                'f_name' => 'required',
                'role_id' => 'required|numeric',
                'email' => 'required|email',
                'password' => 'nullable',
            ];

        }else{
            return [
                'f_name' => 'required',
                'role_id' => 'required|numeric',
                'email' => 'required|email',
                'password' => 'required|min:6',
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
            'name' => __('name'),
            'role_id' => __('permission'),
            'email' => __('email'),
            'password' => __('password'),

        ];
    }



}
