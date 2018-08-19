<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\{
    Exchange,
    Wallet,
    User,
    Transaction
};

class ExchangeController extends Controller
{

    public function __construct(Exchange $exchange, Transaction $transaction)
    {
        $this->Exchange = $exchange;
        $this->Transaction = $transaction;
        $types = Transaction::getTypes();
        $transactions = Transaction::getList();
        $wallets = Wallet::getList();
        $exchanges = Exchange::getList();
        view()->share(compact('types', 'transactions', 'wallets', 'exchanges'));
    }

    public function showCreatExchange()
    {
        $tranExpense = $this->Transaction->getTranByType(Transaction::EXPENSE);
        $tranIncome = $this->Transaction->getTranByType(Transaction::INCOME);
        $wallet = Wallet::where('user_id', Auth::user()->id)->get();
        $transaction = Transaction::where('parent_id', '0')->where('user_id', Auth::user()->id)->get();
        return view('exchanges.create', compact('tranExpense', 'tranIncome'), ['wallets' => $wallet]);
    }

    public function creatExchange(Request $request)
    {
        $rules = [
            'content' => 'max:255|required',
            'money' => 'required|numeric|min:0',
        ];
        $messages = [
            'content.max' => 'Nội dung giao dịch không quá :mã ký tự',
            'money.required' => 'Tiền giao dịch không được bỏ trống',
            'money.numeric' => 'Tiền giao dịch phải là số',
            'money.min' => 'Tiền giao dịch phải lớn hơn :min',
        ];
        $request->validate($rules, $messages);
        $data = $request->all();
        $data['date'] = new Carbon();
        $exchange = new Exchange;
        $exchange = $exchange->create($data);
        $wallet = Wallet::findOrFail($exchange['wallet_id']);
        //dd($exchange['type']);
        if ($exchange['type'] == 0) {
            DB::beginTransaction();

            try {
                $wallet->money = $wallet->money - $data['money'];
                //dd($wallet->money);
                $wallet->save();
                $exchange->save();
                DB::commit();
            } catch (\Exception $exc) {
                DB::rollBack();
                throw new \Exception('Tạo giao dịch lỗi!');
            }


            return redirect()->route('exchange')->with('status', 'Giao dịch thành công');
        } else {
            DB::beginTransaction();

            try {
                $wallet->money = $wallet->money + $data['money'];
                //dd($wallet->money);
                $wallet->save();
                $exchange->save();
                DB::commit();
            } catch (\Exception $exc) {
                DB::rollBack();
                throw new \Exception('Tạo giao dịch lỗi!');
            }


            return redirect()->route('exchange')->with('status', 'Giao dịch thành công');
        }
    }

    public function listExchange()
    {
        $wallet = Wallet::select('id')->where('user_id', Auth::user()->id)->get()->toArray();
        $exchange_expense = Exchange::whereIn('wallet_id', $wallet)->where('type', '0')->orderBy('date', 'DESC')->paginate(10);
        $exchange_income = Exchange::whereIn('wallet_id', $wallet)->where('type', '1')->orderBy('date', 'DESC')->paginate(10);

        return view('exchanges.list', compact('exchange_expense', 'exchange_income'));
    }

    public function edit($id)
    {
        $exchange = Exchange::find($id);
        $transaction = Transaction::where('parent_id', '0')->where('user_id', Auth::user()->id)->where('type', $exchange->type)->get();
        //dd($transaction);

        return view('exchanges.edit', compact('exchange'), ['transactions' => $transaction]);
    }

    public function update(Request $request, $id)
    {
        $exchange = Exchange::find($id);
        $rules = [
            'content' => 'max:255|required',
            'money' => 'required|numeric',
        ];
        $messages = [
            'content.max' => 'Nội dung giao dịch không quá :mã ký tự',
            'money.required' => 'Tiền giao dịch không được bỏ trống',
            'money.numeric' => 'Tiền giao dịch phải là số',
        ];
        $request->validate($rules, $messages);
        $data = $exchange->money - $request->money;
        $exchange->transaction_id = $request->transaction_id;
        $exchange->content = $request->content;
        $exchange->money = $request->money;
        //dd($exchange->money);
        $wallet = Wallet::findOrFail($exchange['wallet_id']);
        //dd($exchange['type']);
        if ($exchange->type == 0) {
            DB::beginTransaction();

            try {
                $wallet->money = $wallet->money + $data;
                //dd($exchange);
                //dd($wallet->money);
                $wallet->save();
                $exchange->save();
                DB::commit();
            } catch (\Exception $exc) {
                DB::rollBack();
                throw new \Exception('Sửa giao dịch lỗi!');
            }


            return redirect()->route('exchange')->with('status', 'Giao dịch thành công');
        } else {
            DB::beginTransaction();

            try {
                $wallet->money = $wallet->money - $data;
                //dd($wallet->money);
                $wallet->save();
                $exchange->save();
                DB::commit();
            } catch (\Exception $exc) {
                DB::rollBack();
                throw new \Exception('Sửa giao dịch lỗi!');
            }


            return redirect()->route('exchange')->with('status', 'Giao dịch thành công');
        }
    }

    public function destroy($id)
    {
        $exchange = Exchange::find($id);
        Exchange::find($id)->delete();
        $wallet = Wallet::findOrFail($exchange['wallet_id']);
        if ($exchange['type'] == 0) {
            $wallet->money = $wallet->money + $exchange['money'];
            $wallet->save();
            return redirect()->route('exchange.list');
        } else {
            $wallet->money = $wallet->money - $exchange['money'];
            $wallet->save();
            return redirect()->route('exchange.list');
        }
    }

    public function report()
    {
        $date = Exchange::select(DB::raw("MONTH(date) as month"))->groupBy(DB::raw("MONTH(date)"))->get()->toArray();
        $date = array_column($date, 'month');
        $expense = Exchange::select(DB::raw("SUM(money) as count"))->where('type','0')->groupBy(DB::raw("MONTH(date),YEAR(date)"))->get()->toArray();
        $expense = array_column($expense, 'count');
        //dd($expense);
        $income = Exchange::select(DB::raw("SUM(money) as count"))->where('type','1')->groupBy(DB::raw("MONTH(date),YEAR(date)"))->get()->toArray();
        $income = array_column($income, 'count');
        return view('exchanges.report')
            ->with('date', json_encode($date))
            ->with('expense',json_encode($expense,JSON_NUMERIC_CHECK))
            ->with('income',json_encode($income,JSON_NUMERIC_CHECK));
    }

}
