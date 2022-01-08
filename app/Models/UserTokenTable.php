<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTokenTable extends Model
{
    private static $_instance = null;
    protected $table = 'user_token';
    protected $fillable = [
        'id',
        'user_id',
        'auth_type',
        'device_id',
        'os_type',
        'token',
        'expired_time',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance() {
        if (is_null ( self::$_instance )) {
            self::$_instance = new UserTokenTable();
        }
        return self::$_instance;
    }
}
