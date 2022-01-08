<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermissionTable extends Model
{
    private static $_instance = null;
    protected $table = 'menu_permission';
    protected $fillable = [
        'id',
        'menu_id',
        'user_role',
        'active_flag',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance() {
        if (is_null ( self::$_instance )) {
            self::$_instance = new MenuPermissionTable();
        }
        return self::$_instance;
    }
}
