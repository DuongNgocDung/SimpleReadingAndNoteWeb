<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->addColumnForLessonsTable();
        $this->addRelatedTables();
        $this->initDataForRelatedTables();
    }

    /**
     * add column content_highlight, hashtag, level_id, category_id, current_view, sort_no
     */
    private function addColumnForLessonsTable()
    {
        try {
            if (Schema::hasTable('lessons')) {
                Schema::table('lessons', function (Blueprint $table) {
                    if (!Schema::hasColumn('lessons', 'content_highlight')) {
                        $table->text('content_highlight')->nullable()->after('content')->comment('Highlight (summary) of content');
                    }
                    if (!Schema::hasColumn('lessons', 'hashtag')) {
                        $table->string('hashtag', 255)->nullable()->after('source_url')->comment('Hashtag of content');
                    }
                    if (!Schema::hasColumn('lessons', 'level_id')) {
                        $table->integer('level_id')->nullable()->after('id')->comment('Level of content, get from lesson_level table');
                    }
                    if (!Schema::hasColumn('lessons', 'category_id')) {
                        $table->integer('category_id')->nullable()->after('id')->comment('Category of content, get from lesson_category table');
                    }
                    if (!Schema::hasColumn('lessons', 'is_recommend')) {
                        $table->integer('is_recommend')->nullable()->after('hashtag')->default(0);
                    }
                    if (!Schema::hasColumn('lessons', 'current_view')) {
                        $table->integer('current_view')->nullable()->after('is_recommend')->default(0)->comment('Count user view of content');
                    }
                    if (!Schema::hasColumn('lessons', 'sort_no')) {
                        $table->integer('sort_no')->nullable()->after('current_view')->default(0);
                    }
                });
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * add upload_files, lesson_level, lesson_category, content_history_report tables
     */
    private function addRelatedTables()
    {
        try {
            /** add related tables **/
            if (!Schema::hasTable('upload_files')) {
                Schema::create('upload_files', function (Blueprint $table) {
                    $table->id();
                    $table->integer('content_type')->nullable()->default(0)->comment('0: public, 1: lessons, 2: user');
                    $table->integer('related_id')->nullable();
                    $table->text('file_url')->nullable();
                    $table->string('file_display_name', 255)->nullable();
                    $table->string('file_real_name', 255)->nullable();
                    $table->string('description', 255)->nullable();
                    $table->integer('sort_no')->nullable()->default(0);
                    $table->dateTime('register_date')->nullable();
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('delete_date')->nullable();
                });
            }

            if (!Schema::hasTable('lesson_level')) {
                Schema::create('lesson_level', function (Blueprint $table) {
                    $table->id();
                    $table->string('name', 100)->nullable();
                    $table->string('description', 255)->nullable();
                    $table->integer('active_flag')->nullable()->default(1);
                    $table->integer('sort_no')->nullable()->default(0);
                    $table->dateTime('register_date')->nullable();
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('delete_date')->nullable();
                });
            }

            if (!Schema::hasTable('lesson_category')) {
                Schema::create('lesson_category', function (Blueprint $table) {
                    $table->id();
                    $table->string('name', 255)->nullable();
                    $table->string('description', 255)->nullable();
                    $table->string('hashtag', 255)->nullable();
                    $table->integer('active_flag')->nullable()->default(1);
                    $table->integer('sort_no')->nullable()->default(0);
                    $table->dateTime('register_date')->nullable();
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('delete_date')->nullable();
                });
            }

            if (!Schema::hasTable('content_history_report')) {
                Schema::create('content_history_report', function (Blueprint $table) {
                    $table->id();
                    $table->integer('content_type')->nullable()->default(0)->comment('0: public, 1: lessons, 2: user');
                    $table->integer('content_id')->nullable();
                    $table->integer('user_id')->nullable()->default(0)->comment('0: guest');
                    $table->integer('view')->nullable()->default(0)->comment('Count view of user');
                    $table->string('os_type')->nullable();
                    $table->dateTime('register_date')->nullable();
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('delete_date')->nullable();
                });
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * add init data for table lesson_level and table lesson_category
     */
    private function initDataForRelatedTables()
    {
        try {
            $now = date('Y-m-d H:i:s');

            $levels = DB::table('lesson_level')->get();
            if (empty($levels) || count($levels) == 0) {
                $initData = [
                    [
                        'id' => 1,
                        'name' => 'N1',
                        'sort_no' => 1,
                        'register_date' => $now
                    ],
                    [
                        'id' => 2,
                        'name' => 'N2',
                        'sort_no' => 2,
                        'register_date' => $now
                    ],
                    [
                        'id' => 3,
                        'name' => 'N3',
                        'sort_no' => 3,
                        'register_date' => $now
                    ],
                    [
                        'id' => 4,
                        'name' => 'N4',
                        'sort_no' => 4,
                        'register_date' => $now
                    ],
                    [
                        'id' => 5,
                        'name' => 'N5',
                        'sort_no' => 5,
                        'register_date' => $now
                    ],
                ];
                foreach ($initData as $data) {
                    DB::table('lesson_level')->insert($data);
                }
            }

            $categories = DB::table('lesson_category')->get();
            if (empty($categories) || count($categories) == 0) {
                $initData = [
                    [
                        'id'            => 1,
                        'name'          => '健康',
                        'sort_no'       => 1,
                        'register_date' => $now
                    ],
                    [
                        'id'            => 2,
                        'name'          => 'ドラマ',
                        'sort_no'       => 2,
                        'register_date' => $now
                    ],
                    [
                        'id'            => 3,
                        'name'          => 'アニメ/漫画',
                        'sort_no'       => 3,
                        'register_date' => $now
                    ],
                    [
                        'id'            => 4,
                        'name'          => 'スポーツ',
                        'sort_no'       => 4,
                        'register_date' => $now
                    ],
                    [
                        'id'            => 6,
                        'name'          => '旅行',
                        'sort_no'       => 6,
                        'register_date' => $now
                    ]
                ];
                foreach ($initData as $data) {
                    DB::table('lesson_category')->insert($data);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
