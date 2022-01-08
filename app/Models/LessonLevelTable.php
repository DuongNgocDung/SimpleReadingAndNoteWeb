<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonLevelTable extends Model
{
    private static $_instance = null;
    protected $table = 'lesson_level';
    protected $fillable = [
        'id',
        'name',
        'description',
        'active_flag',
        'sort_no',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance()
    {
        if (is_null ( self::$_instance )) {
            self::$_instance = new LessonLevelTable();
        }
        return self::$_instance;
    }

    public function getActiveList()
    {
        return self::where('active_flag', 1)->whereNull('delete_date')->get();
    }
}
