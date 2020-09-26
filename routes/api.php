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

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'UserController@list');
        Route::get('user/search/{search}', 'UserController@search');
        Route::delete('user/{user}', 'UserController@destroy');        
    });


});

