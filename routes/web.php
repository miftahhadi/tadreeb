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

// Admin dashboard
Route::name('admin.')->group(function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => 'auth',
    ], function () {
        //Dashboard
        Route::get('/', 'AdminController@index');

        // Lessons
        Route::resource('pelajaran', 'LessonController');
    
        // Exams
        Route::resource('ujian', 'ExamController');
    
        // Questions
        Route::post('ujian/{ujian}/soal/unassign', 'QuestionController@unassignFromExam')->name('ujian.soal.unassign');
        Route::resource('ujian.soal', 'QuestionController')->except('index');
    
        // Groups
        Route::resource('grup', 'GroupController');
    
        // Classrooms
        // Kalau pakai resource, entah kenapa parameternya jadi {kela}
        Route::get('kelas/{kelas}', 'ClassroomController@show')->name('kelas.show');
        Route::get('kelas/{kelas}/edit', 'ClassroomController@edit')->name('kelas.edit');
        Route::put('kelas/{kelas}', 'ClassroomController@update')->name('kelas.update');
        Route::delete('kelas/{kelas}', 'ClassroomController@destroy')->name('kelas.destroy');
        Route::post('kelas', 'ClassroomController@store')->name('kelas.store');
    
        // Users
        Route::resource('user', 'UserController');
    
        // Setting
        Route::get('setting', 'SettingController@index')->name('setting');
    
    });
});
