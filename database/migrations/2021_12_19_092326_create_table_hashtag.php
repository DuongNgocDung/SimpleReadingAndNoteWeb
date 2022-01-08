<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHashtag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // purpose: hint for user when add hashtag for their articles
        Schema::create('hashtag', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->nullable();
            $table->integer('active_flag')->nullable()->default(1);
            $table->string('register_by')->nullable();
            $table->dateTime('register_date')->nullable();
            $table->dateTime('update_date')->nullable();
            $table->dateTime('delete_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_hashtag');
    }
}
