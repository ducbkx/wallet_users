<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wallet extends Model
{

    protected $table = 'wallets';
    protected $fillable = [
        'name', 'money', 'user_id',
    ];

    public static function getList()
    {
        return self::all()
                        ->keyBy('id')
                        ->toArray();
    }

    public static function getWallet()
    {
        $wallet = self::where('user_id', Auth::user()->id);
        return $wallet;
    }

}
