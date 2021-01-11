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

Route::group(['namespace' => 'Admin'], function () {

    

    Route::group(['prefix' => 'pelajaran/{pelajaran}'], function () {
        Route::get('section', 'SectionController@list');
    });

    

    

    Route::get('grup/{grup}/kelas', 'ClassroomController@list');
    Route::get('grup/{grup}/kelas/search/{search}', 'ClassroomController@search');
    Route::delete('grup/{grup}/kelas/{kelas}', 'ClassroomController@destroy');

    Route::get('kelas/{kelas}/pelajaran', 'ClassroomController@lessonList');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user', 'UserController@list');
        Route::get('user/search/{search}', 'UserController@search');
        Route::delete('user/{user}', 'UserController@destroy');    
    });

});

Route::group([
        'namespace' => 'API', 
        'middleware' => 'auth:sanctum',
        'prefix' => 'kelas/{kelas}'
], function () {
    Route::get('pelajaran', 'ClassroomController@lesson');
    Route::post('pelajaran/assign', 'ClassroomController@assignLesson');

    Route::get('ujian', 'ClassroomController@exam');
    Route::post('ujian/assign', 'ClassroomController@assignExam');

    Route::get('user', 'ClassroomController@user');
    Route::post('user/assign', 'ClassroomController@assignUser');
});

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'API'], function() {
    // Lessons
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::get('pelajaran', 'LessonController@list');

    Route::delete('pelajaran/{pelajaran}', 'LessonController@destroy');

    // Exams
    Route::get('ujian/search/{search}', 'ExamController@search');
    Route::get('ujian/{exam:id}', 'ExamController@getExam');
    Route::get('ujian', 'ExamController@list');

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
    Route::get('grup', 'GroupController@list');
    Route::delete('grup/{grup}', 'GroupController@destroy');
});

