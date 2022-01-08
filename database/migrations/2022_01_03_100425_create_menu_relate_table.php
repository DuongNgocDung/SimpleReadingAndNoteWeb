<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMenuRelateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        if (!Schema::hasTable('menu')) {
//            Schema::create('menu', function (Blueprint $table) {
//                $table->id();
//                $table->string('menu_name', 100)->nullable();
//                $table->string('menu_title', 255)->nullable();
//                $table->string('menu_url', 100)->nullable();
//                $table->integer('is_master')->default(0)->nullable()->comment('required menu, means can not remove or off active_flag');
//                $table->integer('is_display')->default(0)->nullable()->comment('check display in navbar');
//                $table->integer('active_flag')->nullable()->default(1);
//                $table->dateTime('register_date')->nullable();
//                $table->dateTime('update_date')->nullable();
//                $table->dateTime('delete_date')->nullable();
//            });
//        }
//
//        if (!Schema::hasTable('menu_permission')) {
//            Schema::create('menu_permission', function (Blueprint $table) {
//                $table->id();
//                $table->integer('menu_id')->nullable();
//                $table->integer('user_role')->nullable()->comment('0: guest; 1: system admin; 2: manager; 3: end-user');
//                $table->integer('active_flag')->nullable()->default(1);
//                $table->dateTime('register_date')->nullable();
//                $table->dateTime('update_date')->nullable();
//                $table->dateTime('delete_date')->nullable();
//            });
//        }
//
//        $now = date('Y-m-d H:i:s');
//        $menus = DB::table('menu')->get();
//        if (empty($menus) || count($menus) == 0) {
//            // insert default menus for web (master menu)
//            $insertData = [
//                [
//                    'menu_name'     => 'home',
//                    'menu_title'    => '好きにやる',
//                    'menu_url'      => '/home',
//                    'is_mater'      => 1,
//                    'is_display'    => 1,
//                    'active_flag'   => 1,
//                    'register_date' => $now
//                ],
//                [
//                    'menu_name'     => 'login',
//                    'menu_title'    => 'ログイン',
//                    'menu_url'      => '/login',
//                    'is_mater'      => 1,
//                    'is_display'    => 1,
//                    'active_flag'   => 1,
//                    'register_date' => $now
//                ],
//                [
//                    'menu_name'     => 'about',
//                    'menu_title'    => '「好きにやる」について',
//                    'menu_url'      => '/about',
//                    'is_mater'      => 0,
//                    'is_display'    => 1,
//                    'active_flag'   => 1,
//                    'register_date' => $now
//                ],
//                [
//                    'menu_name'     => 'register_account',
//                    'menu_title'    => '新規会員登録',
//                    'menu_url'      => '/register-account',
//                    'is_mater'      => 0,
//                    'is_display'    => 0,
//                    'active_flag'   => 1,
//                    'register_date' => $now
//                ],
//                [
//                    'menu_name'     => 'lesson',
//                    'menu_title'    => 'レッスン',
//                    'menu_url'      => '/lesson',
//                    'is_mater'      => 0,
//                    'is_display'    => 1,
//                    'active_flag'   => 1,
//                    'register_date' => $now
//                ],
//            ];
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_releate');
    }
}
