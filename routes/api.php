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

    Route::get('pelajaran', 'LessonController@list');
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::delete('pelajaran/{pelajaran}', 'LessonController@destroy');

    Route::get('ujian', 'ExamController@list');
    Route::get('ujian/search/{search}', 'ExamController@search');
    Route::delete('ujian/{ujian}', 'ExamController@destroy');

    Route::get('grup', 'GroupController@list');
    Route::get('grup/search/{search}', 'GroupController@search');
    Route::delete('grup/{grup}', 'GroupController@destroy');

    Route::get('grup/{grup}/kelas', 'ClassroomController@list');
    Route::get('grup/{grup}/kelas/search/{search}', 'ClassroomController@search');
    Route::delete('grup/{grup}/kelas/{kelas}', 'ClassroomController@destroy');

    Route::get('kelas/{kelas}/pelajaran', 'ClassroomController@lessonList');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'UserController@list');
        Route::get('user/search/{search}', 'UserController@search');
        Route::delete('user/{user}', 'UserController@destroy');        
    });


});

