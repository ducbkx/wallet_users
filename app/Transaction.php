<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{

    use Notifiable;

    protected $table = 'transactions';

    const EXPENSE = 0;
    const INCOME = 1;

    public static function getTypes()
    {
        return [
            self::EXPENSE => 'Chi tiêu',
            self::INCOME => 'Thu nhập',
        ];
    }

    protected $fillable = [
        'type','user_id', 'name', 'parent_id',
    ];

    public static function getList()
    {
        return self::all()
                        ->keyBy('id')
                        ->toArray();
    }
    
    /**
     * Get transactions by type
     * 
     * @param int $type
     * @return Transaction
     */
    public function getTranByType($type=self::EXPENSE)
    {
        return $this->select('id', 'name')
                ->where('parent_id', 0)
                ->where('type', $type)
                ->get();
    }
}
