<?php

namespace App\Http\Controllers;

use App\Common\Constant;
use App\Http\Controllers\Common\Common;
use App\Models\LessonCategoryTable;
use App\Models\LessonLevelTable;
use App\Models\LessonsTable;
use App\Models\LessonWordsRelateTable;
use App\Models\WordsNoteTable;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use Common;
    const UPLOAD_FOLDER_NAME = 'lesson';
    public function __construct()
    {

    }

    public function listLesson(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            $limit = (isset($request->limit) && !empty($request->limit)) ? $request->limit : 10;
            $data = LessonsTable::getInstance()->getListForManage($limit, 'sort_no');
            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function detailLesson(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            if (!isset($request->id)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => "'id' is required"]);
            }

            $data = LessonsTable::getInstance()->where('id', $request->id)->first();

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function loadNotesForLesson(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            if (!isset($request->lesson_id)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => "'lesson_id' is required"]);
            }

            $data = WordsNoteTable::getInstance()->select('words_note.*')
                ->leftJoin('lesson_words_relate', 'lesson_words_relate.word_note_id', '=', 'words_note.id')
                ->leftJoin('lessons', 'lesson_words_relate.lesson_id', '=', 'lessons.id')
                ->where('lesson_words_relate.lesson_id', $request->lesson_id)
                ->whereNull('words_note.delete_date')
                ->whereNull('lessons.delete_date')
                ->whereNull('lesson_words_relate.delete_date')
                ->get();
            $filterData = [];

            foreach ($data as $item) {
                $filterData[] = [
                    'id'       => $item->id,
                    'word'     => $item->word,
                    'furigana' => $item->furigana,
                    'romaji'   => $item->romaji,
                    'meaning'  => $item->meaning,
                    'note'     => $item->note,
                    'example'  => $item->example
                ];
            }

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $filterData]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function saveNewWord(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            if (!isset($request->lesson_id)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => "'lesson_id' is required"]);
            }

            $data = $request->data;
            $word = WordsNoteTable::getInstance()->updateOrCreate(
                [ 'word' => $data['word'] ],
                $data
            );
            LessonWordsRelateTable::getInstance()->updateOrCreate(
                [
                    'lesson_id' => $request->lesson_id,
                    'word_note_id' => $word->id
                ],
                [
                    'lesson_id' => $request->lesson_id,
                    'word_note_id' => $word->id
                ]
            );

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function saveLessonData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            $isDelete = (isset($request->is_delete) && $request->is_delete == 1) ? true : false;
            $data = json_decode(stripslashes($request->data), true);
            $file = $request->uploaded_thumbnail;
            if (!empty($file)) {
                $data['thumbnail'] = $this->handleUploadFiled($file, self::UPLOAD_FOLDER_NAME);

                // TODO : update table upload_files
            }

            $result = LessonsTable::getInstance()->updateLesson($data, $isDelete);

            if ($result == true) {
                return response()->json(['status' => Constant::REQUEST_SUCCESS, 'message' => 'Update data success.']);
            } else {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => 'Update data failed.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function listLessonForManage(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            $limit = (isset($request->limit) && !empty($request->limit)) ? $request->limit : 10;
            $data = LessonsTable::getInstance()->getListForManage($limit);
            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function detailLessonForManage(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            if (!isset($request->id) || empty($request->id)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => '[id] is required']);
            }
            $data = LessonsTable::getInstance()->getById($request->id);
            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }

    public function loadSettingDataForLesson(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception();
            }
            $data = array(
                'listCategories' => LessonCategoryTable::getInstance()->getActiveList(),
                'listContentLevels' => LessonLevelTable::getInstance()->getActiveList()
            );

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $e->getMessage()]);
        }
    }
}
