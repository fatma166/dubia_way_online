<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChargeWalletRequest extends FormRequest
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
                'user_id' => 'required',
                'amount'=>'required'];

        }else{
            return [
                'user_id' => 'required',
                'amount'=>'required'
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
            'user_id' => 'required',
            'amount'=>'required'
        ];
    }


}
