<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletExchangeRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $data = $request->all();
        $wallet_transfers = Wallet::findOrFail($data['wallet_id_transfers']);
        $wallet_receive = Wallet::findOrFail($data['wallet_id_receive']);
        return [
            'content' => 'max:255|required',
            'money' => 'required|numeric|min:0|max:' . $wallet_transfers['money'],
            'wallet_id_transfers' => 'different:wallet_id_receive',
        ];
    }

    /**
     * 
     */
    public function messages()
    {
        return [
            'content.max' => 'Nội dung giao dịch không quá :max ký tự',
            'content.required' => 'Nội dung giao dịch không được để trống',
            'money.required' => 'Tiền giao dịch không được bỏ trống',
            'money.numeric' => 'Tiền giao dịch phải là số',
            'money.min' => 'Tiền giao dịch phải lớn hơn :min',
            'money.max' => 'Tiền trong ví không đủ để giao dịch',
            'wallet_id_transfers.different' => 'Ví nhận tiền và ví chuyển tiền không được giống nhau',
        ];
    }

}
