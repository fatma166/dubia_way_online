<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
class ProductRequest extends FormRequest
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
        if(isset($data['id']))
       $id=$data['id'];
        return [
            'name' => 'required',
            'description' => 'required',
            'summary' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id',
            'discount' => 'required',
            'product_quantity' => 'required',
            'status' => 'required',
            'image' => 'required_if:old_image,null'
           // 'phone' => 'required|unique:vendors,phone,'.$vendor_id.',id,deleted_at,NULL',

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
            'name.required' => 'name is required',
            'description.required' => 'description is required',
            'summary.required' => 'summary is required',
            'price.required' => 'price is required',
            'category_id.required' => 'category_id is required',
            'discount.required' => 'discount is required',
            'product_quantity.required' => 'product_quantity is required',
            'status.required' => 'status is required',
            'image.required' => 'image is required',

        ];
    }*/
    public function attributes()
    {
        return [
            'name' => __('name'),
            'description' => __('description'),
            'summary' => __('summary'),
            'price' => __('price'),
            'category_id' => __('category'),
            'discount' => __('discount'),
            'product_quantity' => __('product_quantity'),
            'status' => __('status'),
            'image' => __('image'),
        ];
    }


}
