<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class AdminRoleRequest extends FormRequest
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
            'name' => 'required',
            'modules' => 'required',
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
            'modules' => __('permission'),

        ];
    }



}
