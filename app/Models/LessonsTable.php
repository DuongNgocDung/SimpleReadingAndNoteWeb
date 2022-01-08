<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LessonsTable extends Model
{
    private static $_instance = null;
    protected $table = 'lessons';
    protected $fillable = [
        'id',
        'category_id',
        'level_id',
        'title',
        'content',
        'content_highlight',
        'thumbnail',
        'author',
        'source_url',
        'hashtag',
        'is_recommend',
        'current_view',
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
            self::$_instance = new LessonsTable();
        }
        return self::$_instance;
    }

    public function getListForManage($limit = 10, $sortBy = null)
    {
        if (empty($sortBy)) {
            $sortBy = 'register_date';
        }
        $data = self::whereNull('delete_date')->limit($limit)->orderByRaw("ISNULL($sortBy), $sortBy ASC")->get()->toArray();
        foreach ($data as $key => $item) {
            $data[$key]['register_date'] = strtotime($item['register_date']);
        }
        return $data;
    }

    public function getById($id)
    {
        $data = self::where('id', $id)->whereNull('delete_date')->first();
        if (!empty($data)) {
            $data->register_date = strtotime($data->register_date);
            $data->update_date = strtotime($data->update_date);
            $data->delete_date = strtotime($data->delete_date);
        }
        return $data;
    }

    public function updateLesson($data, $isDelete)
    {
        try {
            $now = date('Y-m-d H:i:s');
            if ($isDelete) {
                if (isset($data['id']) && !empty($data['id'])) {
                    self::where('id', $data['id'])->update(['delete_date' => $now]);
                } else {
                    return false;
                }
            } else {
                $updateData = array(
                    'category_id' => isset($data['category_id']) ? $data['category_id'] : null,
                    'level_id' => isset($data['level_id']) ? $data['level_id'] : null,
                    'title' => isset($data['title']) ? $data['title'] : null,
                    'content' => isset($data['content']) ? $data['content'] : null,
                    'content_highlight' => isset($data['content_highlight']) ? $data['content_highlight'] : null,
                    'thumbnail' => isset($data['thumbnail']) ? $data['thumbnail'] : null,
                    'author' => isset($data['author']) ? $data['author'] : null,
                    'source_url' => isset($data['source_url']) ? $data['source_url'] : null,
                    'hashtag' => isset($data['hashtag']) ? $data['hashtag'] : null,
                    'is_recommend' => isset($data['recommend']) ? $data['is_recommend'] : 0,
                    'sort_no' => isset($data['sort_no']) ? $data['sort_no'] : null,
                    'update_date' => $now
                );
                if (!isset($data['id']) || empty($data['id'])) {
                    $updateData['register_date'] = $now;
                    self::insertGetId($updateData);
                } else {
                    $updateData['id'] = $data['id'];
                    if ($isDelete) $updateData['delete_date'] = $now;
                    self::where('id', $data['id'])->update($updateData);
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
