<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
                'name'        =>'required|unique:locations,name',
                'e_period'       =>'required',
                's_period'      =>'required',
            ];
    }

    public function messages()
    {
        return
            [
                'name.required'         => __('برجاء ادخال اسم المنطقة'),
                'name.unique'         => __('اسم المنطقة موجود بالفعل'),
                'e_period.required'           => __('برجاء اختيار بداية المدة'),
                's_period.required'           => __('برجاء اختيار نهاية المدة'),
            ];
    }
}
