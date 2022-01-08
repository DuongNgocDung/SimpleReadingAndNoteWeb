<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

Route::post('/user/confirm-login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/user/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->middleware('check_auth');
Route::post('/user/register', [\App\Http\Controllers\UserController::class, 'registerAccount']);
Route::post('/user/app-info', [\App\Http\Controllers\UserController::class, 'getAppInfo'])->middleware('check_auth');

Route::post('/lesson/list', [\App\Http\Controllers\LessonController::class, 'listLesson']);
Route::post('/lesson/detail-by-id', [\App\Http\Controllers\LessonController::class, 'detailLesson']);
Route::post('/lesson/notes-by-lesson', [\App\Http\Controllers\LessonController::class, 'loadNotesForLesson']);
Route::post('/lesson/save-word', [\App\Http\Controllers\LessonController::class, 'saveNewWord']);
Route::post('/lesson/admin/save-lesson', [\App\Http\Controllers\LessonController::class, 'saveLessonData']);
Route::post('/lesson/admin/list', [\App\Http\Controllers\LessonController::class, 'listLessonForManage']);
Route::post('/lesson/admin/detail', [\App\Http\Controllers\LessonController::class, 'detailLessonForManage']);
Route::post('/lesson/admin/get-setting-data', [\App\Http\Controllers\LessonController::class, 'loadSettingDataForLesson']);