<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\ExchangeUpdateRequest;
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
        $transaction = Transaction::getTran()->where('parent_id', '0')->get();
        return view('exchanges.create', compact('tranExpense', 'tranIncome'), ['wallets' => $wallet]);
    }

    public function creatExchange(ExchangeRequest $request)
    {
        $data = $request->all();
        $data['date'] = new Carbon();
        $exchange = new Exchange;
        $exchange = $exchange->create($data);
        $wallet = Wallet::findOrFail($exchange['wallet_id']);
        //dd($exchange['type']);
        if ($exchange['type'] == Transaction::EXPENSE) {
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
        $exchange_expense = Exchange::getExchange()->where('type', Transaction::EXPENSE)->orderBy('date', 'DESC')->paginate(10);
        $exchange_income = Exchange::getExchange()->where('type', Transaction::INCOME)->orderBy('date', 'DESC')->paginate(10);

        return view('exchanges.list', compact('exchange_expense', 'exchange_income'));
    }

    public function edit($id)
    {
        $exchange = Exchange::find($id);
        $transaction = Transaction::getTranParent()->where('user_id', Auth::user()->id)->where('type', $exchange->type)->get();
        //dd($transaction);

        return view('exchanges.edit', compact('exchange'), ['transactions' => $transaction]);
    }

    public function update(ExchangeUpdateRequest $request, $id)
    {
        $exchange = Exchange::find($id);
        $data = $exchange->money - $request->money;
        $exchange->transaction_id = $request->transaction_id;
        $exchange->content = $request->content;
        $exchange->money = $request->money;
        //dd($exchange->money);
        $wallet = Wallet::findOrFail($exchange['wallet_id']);
        //dd($exchange['type']);
        if ($exchange->type == Transaction::EXPENSE) {
            DB::beginTransaction();

            try {
                $wallet->money = $wallet->money + $data;
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
        if ($exchange['type'] == Transaction::EXPENSE) {
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
        $date = Exchange::select(DB::raw("MONTH(date) as month"))
                ->groupBy(DB::raw("MONTH(date)"))->get()
                ->toArray();
        $date = array_column($date, 'month');
        $expense = Exchange::select(DB::raw("SUM(money) as count"))
                ->where('type', 'EXPENSE')
                ->groupBy(DB::raw("MONTH(date),YEAR(date)"))
                ->get()
                ->toArray();
        $expense = array_column($expense, 'count');
        //dd($expense);
        $income = Exchange::select(DB::raw("SUM(money) as count"))
                ->where('type', 'INCOME')
                ->groupBy(DB::raw("MONTH(date),YEAR(date)"))
                ->get()
                ->toArray();
        $income = array_column($income, 'count');
        return view('exchanges.report')
                        ->with('date', json_encode($date))
                        ->with('expense', json_encode($expense, JSON_NUMERIC_CHECK))
                        ->with('income', json_encode($income, JSON_NUMERIC_CHECK));
    }

}
