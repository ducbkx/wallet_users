<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\{
    Wallet,
    User
};

class WalletController extends Controller
{

    public function __construct(Wallet $wallet)
    {
        $this->Wallet = $wallet;
        $wallets = Wallet::getList();
    }

    public function showCreateWallet()
    {
        return view('wallets.creat');
    }

    public function creatWallet(Request $request)
    {
        $rules = [
            'name' => 'required|min:4|max:100|unique:wallets',
            'money' => 'required|numeric|min:0',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.min' => 'Tên ví phải lớn hơn :min ký tự',
            'name.max' => 'Tên ví phải nhỏ hơn :max ký tự',
            'name.unique' => 'Tên ví đã tồn tại',
            'money.numeric' => 'Tiền trong ví phải là số',
            'money.min' => 'Tiền trong ví phải lớn hơn :min',];
        $request->validate($rules, $messages);
        
        $wallet['name'] = $request->name;
        $wallet['money'] = $request->money;
        $wallet['user_id'] = Auth::user()->id;
        if ($this->Wallet->fill($wallet)->save()) {
            return redirect()->route('wallet.list');
        }
    }

    public function listWallet()
    {
        $wallet = Wallet::where('user_id', Auth::user()->id)->paginate(5);
        return view('wallets.list', ['wallets' => $wallet]);
    }
    public function edit($id)
    {
        $wallet = Wallet::find($id);
        return view('wallets.edit', compact('wallet'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update(Request $request, $id)
    {
        $wallet = Wallet::find($id);
        $rules = [
            'money' => 'required|numeric|min:0',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.min' => 'Tên ví phải lớn hơn :min ký tự',
            'name.max' => 'Tên ví phải nhỏ hơn :max ký tự',
            'name.unique' => 'Tên ví đã tồn tại',
            'money.numeric' => 'Tiền trong ví phải là số',
            'money.min' => 'Tiền trong ví phải lớn hơn :min',
        ];
        if ($wallet->name != $request->get('name')) {
            $rules['name'] = 'required|min:4|max:100|unique:wallets';
        }
        $request->validate($rules, $messages);

        $wallet -> name = $request-> name;
        $wallet -> money = $request -> money;
        if ($wallet->save()) {
            return redirect()->route('wallet.list');
        }
    }

    public function destroy($id)
    {
        Wallet::find($id)->delete();
        return redirect()->route('wallet.list');
    }
public function WalletExchange(){
    $wallet = Wallet::where('user_id', Auth::user()->id);
    return view('wallets.exchange', ['wallets' => $wallet]);
}

}
