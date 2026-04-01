<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Modules\Core\HTTPResponseCodes;
class OfferRequest extends FormRequest
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
            'type' => 'required',
            'is_active' => 'required',
            
            'restaurant_id' => 'required|numeric|exists:restaurants,id',
            


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
            'type' => __('title'),
            'is_active' => __('status'),
            'restaurant_id' => __('restaurant_id'),
                    ];
    }


}