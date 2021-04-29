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
    Route::post('user/process-csv', 'UserController@processCsv');
    Route::resource('user', 'UserController');

    // Lessons
    Route::get('pelajaran/slug/{slug}', 'LessonController@getSlug');
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::resource('pelajaran', 'LessonController');

    // Exams
    Route::get('ujian/search/{search}', 'ExamController@search');

    Route::post('ujian/{ujian}/assign-soal', 'ExamController@assignQuestion');
    Route::post('ujian/unassign-soal', 'ExamController@unassignQuestion');

    Route::resource('ujian', 'ExamController');

    Route::group(['prefix' => 'ujian/{ujian}'], function() {
        Route::get('kelas', 'ExamController@getClassrooms');

        Route::get('soal/{soal}', 'ExamController@getQuestion');
        Route::put('update-jawaban', 'ExamController@updateUserAnswers');
        Route::post('submit-ujian', 'ExamController@submitExam');
    });

    // Question
    Route::get('soal/search/{search}', 'QuestionController@search');
    Route::get('soal', 'QuestionController@index');

    Route::delete('soal/{soal}/jawaban/{jawaban}', 'QuestionController@deleteAnswer');
    Route::post('soal', 'QuestionController@store');
    Route::put('soal/{soal}', 'QuestionController@update');
    Route::delete('soal/{soal}', 'QuestionController@destroy');

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
        Route::get('anggota', 'ClassroomController@member');
    });

    Route::resource('kelas', 'ClassroomController');

    Route::delete('/user-exam-record/{examableUser}', 'ExamableUserController@destroy');

});

