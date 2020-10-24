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
    
        // Classrooms
        // Kalau pakai resource, entah kenapa parameternya jadi {kela}
        Route::name('grup.kelas.')->group(function() {
            Route::group(['prefix' => 'grup/{grup}/'], function () { 
                Route::get('kelas/{kelas}', 'ClassroomController@show')->name('show');
                
                Route::post('kelas', 'ClassroomController@store')->name('store');
                Route::put('kelas/{kelas}', 'ClassroomController@update')->name('update');
                Route::delete('kelas/{kelas}', 'ClassroomController@destroy')->name('destroy');
                Route::get('kelas/{kelas}/edit', 'ClassroomController@edit')->name('edit');

                Route::get('kelas/{kelas}/pelajaran', 'ClassroomController@pelajaran');
                Route::get('kelas/{kelas}/pelajaran/assign', 'ClassroomController@assignPelajaran');

                Route::get('kelas/{kelas}/ujian', 'ClassroomController@ujian');
                Route::get('kelas/{kelas}/ujian/assign', 'ClassroomController@ujian');


                Route::get('kelas/{kelas}/anggota', 'ClassroomController@anggota');
                Route::get('kelas/{kelas}/anggota/assign', 'ClassroomController@anggota');

                Route::get('kelas/{kelas}/pengaturan', 'ClassroomController@pengaturan');
                Route::post('kelas/{kelas}/pengaturan', 'ClassroomController@pengaturan');


            });
        });

        // Groups
        Route::resource('grup', 'GroupController');
    
        // Users
        Route::post('user/process-csv', 'UserController@processCsv')->name('user.processCsv');
        
        Route::get('user/import-csv', 'UserController@getCsv')->name('user.getCsv');
        Route::post('user/parse-csv', 'UserController@parseCsv')->name('user.parseCsv');

        Route::resource('user', 'UserController');
    
        // Setting
        Route::resource('setting', 'SettingController')->only(['index', 'store']);
    
    });
});
