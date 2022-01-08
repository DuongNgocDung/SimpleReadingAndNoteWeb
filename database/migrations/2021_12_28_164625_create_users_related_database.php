<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersRelatedDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('login_account')) {
            Schema::create('login_account', function (Blueprint $table) {
                $table->id();
                $table->string('login_id', 100)->nullable()->unique()->comment('Login account email/username;');
                $table->text('password')->nullable();
                $table->integer('auth_type')->nullable()->default(3)->comment('0: guest; 1: system admin; 2: manager; 3: end-user');
                $table->string('first_name', 255)->nullable();
                $table->string('last_name', 255)->nullable();
                $table->integer('gender')->nullable()->comment('1: male; 2: female; 3: others');
                $table->date('birthday')->nullable();
                $table->string('avatar_url', 255)->nullable();
                $table->string('email_address', 255)->nullable();
                $table->string('email_address2', 255)->nullable();
                $table->integer('language')->nullable()->default(1)->comment('1: Japanese; 2: Vietnamese; 3: English');
                $table->dateTime('register_date')->nullable();
                $table->dateTime('update_date')->nullable();
                $table->dateTime('delete_date')->nullable();
            });
        }
        // TODO : add some more details for end-user
//        if (!Schema::hasTable('user_detail')) {
//            Schema::create('user_detail', function (Blueprint $table) {
//                $table->id();
//                $table->integer('login_account_id')->nullable();
//                $table->string('nickname', 100)->nullable();
//
//            });
//        }

        if (!Schema::hasTable('user_token')) {
            Schema::create('user_token', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->integer('auth_type')->nullable();
                $table->string('device_id', 100)->nullable();
                $table->string('os_type', 100)->nullable()->comment('ios, android, web');
                $table->text('token')->nullable();
                $table->dateTime('expired_time')->nullable();
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
        Schema::dropIfExists('users_related_database');
    }
}
