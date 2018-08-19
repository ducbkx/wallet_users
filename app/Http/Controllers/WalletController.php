<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\{
    Wallet,
    User,
    WalletExchange
};

class WalletController extends Controller
{

    public function __construct(Wallet $wallet)
    {
        $this->Wallet = $wallet;
        $wallets = Wallet::getList();
        view()->share(compact($wallets));
    }

    public function showCreateWallet()
    {
        return view('wallets.creat');
    }

    public function creatWallet(Request $request)
    {
        $data = Wallet::select('name')->where('user_id', Auth::user()->id)->get();
        $rules = [
            'name' => 'required|min:4|max:100|unique:',
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
            'name' => 'required|min:4|max:100|unique:wallets',
            'money' => 'required|numeric|min:0'
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

        $wallet->name = $request->name;
        $wallet->money = $request->money;
        if ($wallet->save()) {
            return redirect()->route('wallet.list');
        }
    }

    public function destroy($id)
    {
        Wallet::find($id)->delete();
        return redirect()->route('wallet.list');
    }

    public function WalletExchange()
    {

        $wallet = Wallet::where('user_id', Auth::user()->id)->get();
        return view('wallets.wallet_exchange', ['wallets' => $wallet]);
    }

    public function WalletActionExchange(Request $request)
    {
        $data = $request->all();
        $wallet_transfers = $this->Wallet->findOrFail($data['wallet_id_transfers']);
        $wallet_receive = $this->Wallet->findOrFail($data['wallet_id_receive']);
        $rules = [
            'content' => 'max:255|required',
            'money' => 'required|numeric|min:0|max:' . $wallet_transfers['money'],
            'wallet_id_transfers' => 'different:wallet_id_receive',
        ];

        $messages = [
            'content.max' => 'Nội dung giao dịch không quá :mã ký tự',
            'content.required' => 'Nội dung giao dịch không được để trống',
            'money.required' => 'Tiền giao dịch không được bỏ trống',
            'money.numeric' => 'Tiền giao dịch phải là số',
            'money.min' => 'Tiền giao dịch phải lớn hơn :min',
            'money.max' => 'Tiền trong ví không đủ để giao dịch',
            'wallet_id_transfers.different' => 'Ví nhận tiền và ví chuyển tiền không được giống nhau',
        ];

        $request->validate($rules, $messages);
        $wallet_exchange = new WalletExchange;
        $data['date'] = new Carbon();
        //dd($wallet_transfers->money);

        DB::beginTransaction();
        try {
            $wallet_exchange = $wallet_exchange->create($data);
            $wallet_transfers->money = $wallet_transfers->money - $wallet_exchange->money;
            $wallet_receive->money = $wallet_receive->money + $wallet_exchange->money;
            $wallet_exchange->save();
            $wallet_transfers->save();
            $wallet_receive->save();
            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();
            throw new \Exception('Tạo giao dịch lỗi!');
        }


        return redirect()->route('wallet.exchange')->with('status', 'Chuyển tiền thành công');
    }

}
