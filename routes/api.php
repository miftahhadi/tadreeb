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
    Route::resource('user', 'UserController');

    // Lessons
    Route::get('pelajaran/slug/{slug}', 'LessonController@getSlug');
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::resource('pelajaran', 'LessonController');

    // Exams
    Route::get('ujian/search/{search}', 'ExamController@search');
    Route::get('ujian/{exam:id}', 'ExamController@getExam');
    Route::get('ujian/slug/{slug}', 'ExamController@getSlug');
    Route::resource('ujian', 'ExamController');

    Route::delete('ujian/{ujian}', 'ExamController@destroy');
    
    Route::get('soal/{soal}', 'ExamController@getQuestion');
    Route::get('jawaban-user/{classexamuser}', 'ExamController@getUserAnswers');
    Route::post('update-jawaban', 'ExamController@updateUserAnswers');
    Route::post('submit-ujian', 'ExamController@submitExam');

    Route::post('section/{section}/ujian/assign', 'SectionController@assignExam');

    // Setting
    Route::get('ujian/{exam:id}/setting', 'SettingController@getExamSetting');
    Route::post('ujian/setting', 'SettingController@saveExamSetting');

    // Group
    Route::get('grup/search/{search}', 'GroupController@search');
    Route::resource('grup', 'GroupController');

    // Classrooms
    Route::get('grup/{grup}/kelas/search/{search}', 'ClassroomController@search');

    Route::group(['prefix' => 'kelas/{kelas}'], function () {
        Route::get('pelajaran', 'ClassroomController@lesson');
        Route::post('pelajaran/assign', 'ClassroomController@assignLesson');

        Route::get('ujian', 'ClassroomController@exam');
        Route::post('ujian/assign', 'ClassroomController@assignExam');

        Route::get('user', 'ClassroomController@user');
        Route::post('user/assign', 'ClassroomController@assignUser');
    });

    Route::resource('grup/{grup}/kelas', 'ClassroomController');

});

