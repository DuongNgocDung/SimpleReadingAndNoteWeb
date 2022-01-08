<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWordsRelateTable extends Model
{
    private static $_instance = null;
    protected $table = 'lesson_words_relate';
    protected $fillable = [
        'id',
        'lesson_id',
        'word_note_id',
        'sort_no',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance() {
        if (is_null ( self::$_instance )) {
            self::$_instance = new LessonWordsRelateTable();
        }
        return self::$_instance;
    }
}
