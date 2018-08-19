<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletExchange extends Model
{
     protected $table = 'wallet_exchange';
     
      protected $fillable = [
        'wallet_id_transfers', 'wallet_id_receive', 'content','money','date'
    ];
      
   
}
