<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Exchange extends Model
{

    use Notifiable;


    protected $table = 'exchanges';
    protected $fillable = [
        'type', 'wallet_id', 'transaction_id', 'content', 'money', 'date',
    ];

    public static function getList()
    {
        return self::all()
                        ->keyBy('id')
                        ->toArray();
    }

}
