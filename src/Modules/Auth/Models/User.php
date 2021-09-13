<?php

namespace Spirit1086\Restfull\Modules\Auth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'api_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_token','access_token_expires_date'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setData(array $where_condition,array $values)
    {
        return  User::updateOrCreate($where_condition,$values);
    }

    public static function getData($username)
    {
        return  User::where('username','=',$username)->first();
    }

    public function getItem($key,$value)
    {
        return User::where($key,'=',$value)->first();
    }

    public static function getAll()
    {
        return User::all();
    }
}
