<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletRequest extends FormRequest
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
            'name' => 'required|min:4|max:100|unique:wallets,user_id,' .Auth::user()->id,
            'money' => 'required|numeric|min:0',
        ];
    }

    /**
     * 
     */
    public function messages()
    {
        return [
            'required' => 'Trường không được bỏ trống',
            'name.min' => 'Tên ví phải lớn hơn :min ký tự',
            'name.max' => 'Tên ví phải nhỏ hơn :max ký tự',
            'name.unique' => 'Tên ví đã tồn tại',
            'money.numeric' => 'Tiền trong ví phải là số',
            'money.min' => 'Tiền trong ví phải lớn hơn :min',
        ];
    }

}
