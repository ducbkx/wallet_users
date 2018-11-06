<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
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
            'content' => 'max:255|required',
            'money' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'content.max' => 'Nội dung giao dịch không quá :mã ký tự',
            'content.required' => 'Nội dung giao dịch không được để trống',
            'money.required' => 'Tiền giao dịch không được bỏ trống',
            'money.numeric' => 'Tiền giao dịch phải là số',
            'money.min' => 'Tiền giao dịch phải lớn hơn :min',
        ];
    }

}
