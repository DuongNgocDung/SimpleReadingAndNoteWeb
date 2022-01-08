<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable();
                $table->text('content')->nullable();
                $table->string('thumbnail', 255)->nullable();
                $table->string('author', 255)->nullable();
                $table->text('source_url')->nullable();
                $table->dateTime('register_date')->nullable();
                $table->dateTime('update_date')->nullable();
                $table->dateTime('delete_date')->nullable();
            });
        }

        if (!Schema::hasTable('words_note')) {
            Schema::create('words_note', function(Blueprint $table) {
                $table->id();
                $table->string('word', 255)->nullable()->unique();
                $table->string('furigana', 255)->nullable();
                $table->string('romaji', 255)->nullable();
                $table->string('meaning', 255)->nullable();
                $table->string('note', 255)->nullable();
                $table->text('example')->nullable();
                $table->dateTime('register_date')->nullable();
                $table->dateTime('update_date')->nullable();
                $table->dateTime('delete_date')->nullable();
            });
        }

        if (!Schema::hasTable('lesson_words_relate')) {
            Schema::create('lesson_words_relate', function(Blueprint $table) {
                $table->id();
                $table->integer('lesson_id')->nullable();
                $table->integer('word_note_id')->nullable();
                $table->integer('sort_no')->nullable();
                $table->dateTime('register_date')->nullable();
                $table->dateTime('update_date')->nullable();
                $table->dateTime('delete_date')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('words_note');
        Schema::dropIfExists('lesson_words_relate');
    }
}
