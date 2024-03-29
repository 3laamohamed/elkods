<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class customerMoneyRequest extends FormRequest
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
                'customer'   =>'required',
                'money'      =>'required',
            ];
    }

    public function messages()
    {
        return
            [
                'customer.required'      => __('برجاء اختيار العميل'),
                'money.required'         => __('برجاء ادخال قيمة'),
            ];
    }
}
