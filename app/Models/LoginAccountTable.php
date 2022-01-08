<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAccountTable extends Model
{
    private static $_instance = null;
    protected $table = 'login_account';
    protected $fillable = [
        'id',
        'login_id',
        'password',
        'auth_type',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'avatar_url',
        'email_address',
        'email_address2',
        'language',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance() {
        if (is_null ( self::$_instance )) {
            self::$_instance = new LoginAccountTable();
        }
        return self::$_instance;
    }

    public function getAccountLoginData($loginId, $password)
    {
        return self::where(['login_id' => $loginId, 'password' => md5($password)])
            ->whereNull('delete_date')
            ->first();
    }
}
