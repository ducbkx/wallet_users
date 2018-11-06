<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Wallet;

class WalletUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Wallet::where('user_id', Auth::user()->id)->get();
        ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {   
        $wallet = Wallet::find($this->id);
        $rules = [
            'money' => 'required|numeric|min:0'
        ];
        if ($wallet->name!= $request->get('name')) {
            $rules['name'] = 'required|min:4|max:100|unique:wallets';
        }
        return $rules;
    }

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
