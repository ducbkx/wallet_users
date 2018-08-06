<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
     protected $fillable = [
        'name','money','user_id',
    ];
     public static function getList()
    {
        return self::all()
                ->keyBy('id')
                ->toArray();
    }
}
