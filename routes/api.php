<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'API'], function() {
    // Users
    Route::get('user/search/{search}', 'UserController@search');
    Route::get('user/check-data', 'UserController@checkData');
    Route::resource('user', 'UserController');

    // Lessons
    Route::get('pelajaran/slug/{slug}', 'LessonController@getSlug');
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::resource('pelajaran', 'LessonController');

    // Exams
    Route::get('ujian/search/{search}', 'ExamController@search');
    Route::resource('ujian', 'ExamController');

    Route::group(['prefix' => 'ujian/{ujian}'], function() {
        Route::get('kelas', 'ExamController@getClassrooms');

        Route::get('soal/{soal}', 'ExamController@getQuestion');
        Route::get('jawaban-user/{classexamuser}', 'ExamController@getUserAnswers');
        Route::post('update-jawaban', 'ExamController@updateUserAnswers');
        Route::post('submit-ujian', 'ExamController@submitExam');
    });

    Route::post('section/{section}/ujian/assign', 'SectionController@assignExam');

    // Setting
    Route::get('ujian/{exam:id}/setting', 'SettingController@getExamSetting');
    Route::post('ujian/setting', 'SettingController@saveExamSetting');

    // Group
    Route::get('grup/search/{search}', 'GroupController@search');
    Route::resource('grup', 'GroupController');

    // Classrooms
    Route::get('grup/{grup}/kelas/search/{search}', 'GroupController@searchClassrooms');
    Route::get('grup/{grup}/kelas', 'GroupController@listClassrooms');


    Route::group(['prefix' => 'kelas/{kelas}'], function () {
        Route::post('assign', 'ClassroomController@assignItem');
        Route::post('unassign', 'ClassroomController@unassignItem');

        Route::get('pelajaran', 'ClassroomController@lesson');
        Route::get('ujian', 'ClassroomController@exam');
        Route::get('user', 'ClassroomController@user');
    });

    Route::resource('kelas', 'ClassroomController');

});

