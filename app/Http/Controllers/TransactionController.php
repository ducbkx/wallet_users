<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\{
    Wallet,
    User,
    Transaction
};

class TransactionController extends Controller
{

    public function __construct(Transaction $transaction)
    {
        $this->Transaction = $transaction;
        $types = Transaction::getTypes();
        $transactions = Transaction::getList();
        view()->share(compact('types', 'transactions'));
    }

    public function showCreatTransaction()
    {
        $tranExpense = $this->Transaction->getTranByType(Transaction::EXPENSE);
        $tranIncome  = $this->Transaction->getTranByType(Transaction::INCOME);
        
        return view('transactions.create', compact('tranExpense', 'tranIncome'));
    }

    public function creatTransaction(Request $request)
    {
        $rules = [
            'name' => 'required|max:50'
        ];
        $messages = [
            'required' => 'Tên giao dịch không được để trống',
            'max' => 'Tên ví không được nhiều hơn :max ký tự'
        ];
        $request->validate($rules, $messages);
        $transaction = $request->all();
        $transaction['parent_id'] = $request->parent_id;
        $transaction['user_id'] = Auth::user()->id;
        if ($this->Transaction->fill($transaction)->save()) {
            return redirect()->route('transaction.list');
        }
    }

    public function listTransaction()
    {
        $collection = Transaction::where('user_id', Auth::user()->id)->paginate(10);
        $tranParent = Transaction::where('parent_id', '0')->get();
        $transactions = array();
        if ($tranParent) {
            foreach ($tranParent as $transaction) {
                $transactions[$transaction['id']] = $transaction;
            }
        }

        return view('transactions.list', compact('transactions', 'collection'));
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $transaction_parent = Transaction::where('parent_id', '0')->where('type', $transaction->type)->get();
        
        return view('transactions.edit', compact('transaction','transaction_parent'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $rules = [
            'name' => 'required|max:100'
        ];
        $messages = [
            'required' => 'Tên giao dịch không được để trống',
            'max' => 'Tên giao dịch không được nhiều hơn :max ký tự'
        ];
        $request->validate($rules, $messages);

        $transaction->name = $request->name;
        $transaction->parent_id = $request->parent_id;
        if ($transaction->save()) {
            return redirect()->route('transaction.list');
        }
    }

    public function destroy($id)
    {
        Transaction::find($id)->delete();
        return redirect()->route('transaction.list');
    }

}
