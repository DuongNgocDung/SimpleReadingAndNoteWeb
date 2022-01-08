<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordsNoteTable extends Model
{
    private static $_instance = null;
    protected $table = 'words_note';
    protected $fillable = [
        'id',
        'word',
        'furigana',
        'romaji',
        'meaning',
        'note',
        'example',
        'register_date',
        'update_date',
        'delete_date',
    ];
    const CREATED_AT =  'register_date';
    const UPDATED_AT =  'update_date';

    public static function getInstance() {
        if (is_null ( self::$_instance )) {
            self::$_instance = new WordsNoteTable();
        }
        return self::$_instance;
    }
}
