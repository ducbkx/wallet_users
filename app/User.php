<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const SEX_MALE = 1;
    const SEX_FEMALE = 0;
    
    public static function getGenders()
    {
        return [ 
            self::SEX_MALE => 'Male',
            self::SEX_FEMALE => 'Female',
        ];
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','name', 'password','gender','avatar','birthday','verified','token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'rememberToken',
    ];
}
