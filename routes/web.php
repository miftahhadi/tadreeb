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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth'
], function () {
        
    // Admin dashboard
    Route::get('/', 'AdminController@index')->name('admin');

    // Lessons
    Route::get('pelajaran/list', 'LessonController@list');
    Route::get('pelajaran/search/{search}', 'LessonController@search');
    Route::resource('pelajaran', 'LessonController');

    // Exams
    Route::get('ujian/search/{search}', 'ExamController@search');
    Route::get('ujian/list', 'ExamController@list');
    Route::resource('ujian', 'ExamController');

    // Questions
    Route::post('ujian/{ujian}/soal/unassign', 'QuestionController@unassignFromExam')->name('ujian.soal.unassign');
    Route::resource('ujian.soal', 'QuestionController')->except('index');

    // Users
    Route::get('user/search/{search}', 'UserController@search');
    Route::get('user/list', 'UserController@list');
    Route::resource('user', 'UserController');

    // Setting
    Route::get('setting', function () {
      return 0;  
    })->name('setting');

});