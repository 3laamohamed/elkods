<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
        return
            [
                'name'           =>'required|unique:products,name',
                'price'          =>'required',
                'pay_price'      =>'required',
                'qty'            =>'required',
            ];
    }

    public function messages()
    {
        return
            [
                'name.required'      => 'برجاء ادخال اسم المنتج',
                'name.unique'        => 'اسم المنتج موجود بالفعل',
                'price.required'     => 'برجاء ادخال السعر',
                'pay_price.required' => 'برجاء ادخال سعر البيع',
                'qty.required'       => 'برجاء ادخال الكمية',
            ];
    }
}
