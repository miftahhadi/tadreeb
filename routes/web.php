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
    'namespace' => 'Admin'
], function () {
        
    // Admin dashboard
    Route::get('/', 'AdminController@index');

    // Lessons
    Route::resource('pelajaran', 'LessonController');

    // Exams
    Route::resource('ujian', 'ExamController');

    // Questions
    Route::post('ujian/{ujian}/soal/unassign', 'QuestionController@unassignFromExam')->name('ujian.soal.unassign');
    Route::resource('ujian.soal', 'QuestionController')->except('index');

});