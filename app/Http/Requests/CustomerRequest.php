<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                'name'        =>'required|unique:customers,name',
                'phone'        =>'unique:customers,phone',
                'type'       =>'required',
                'location'   =>'required',
            ];
    }

    public function messages()
    {
        return
            [
                'name.required'         => __('برجاء ادخال اسم العميل'),
                'name.unique'         => __('اسم العميل موجود بالفعل'),
                'phone.unique'         => __('هاتف العميل موجود بالفعل'),
                'type.required'           => __('برجاء اختيار النوع'),
                'location.required'           => __('برجاء اختيار المنطقة'),
            ];
    }
}
