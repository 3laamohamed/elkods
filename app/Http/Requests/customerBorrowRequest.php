<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class customerBorrowRequest extends FormRequest
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
                'borrow'      =>'required',
            ];
    }

    public function messages()
    {
        return
            [
                'customer.required'      => 'برجاء اختيار العميل',
                'borrow.required'         => 'برجاء ادخال قيمة السلفة',
                'money.required'        => 'برجاء ادخال المخصوم كل فترة',
            ];
    }
}
