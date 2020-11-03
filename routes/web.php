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

// Front area
Route::group(['namespace' => 'Front', 'middleware' => 'auth'], function (){

    // Dashboard
    Route::get('/dashboard', 'FrontController@index')->name('dashboard');

    Route::group(['prefix' => 'k'], function () {

        Route::redirect('/{classroom:kode}', '/k/{classroom:kode}/depan');

        Route::get('/{classroom:kode}/depan', 'ClassroomController@showHome')->name('kelas.home');
        Route::get('/{classroom:kode}/pelajaran', 'ClassroomController@showLessons')->name('kelas.lessons');
        Route::get('/{classroom:kode}/works', 'ClassroomController@showWorks')->name('kelas.works');
        Route::get('/{classroom:kode}/anggota', 'ClassroomController@showPeople')->name('kelas.people');

        Route::get('/{classroom:kode}/u/{exam}', 'ClassroomExamController@showInfo')->name('kelas.exam.info');
        Route::get('/{classroom:kode}/u/{exam}/kerjakan', 'ClassroomExamController@showExam')->name('kelas.exam.kerjakan');

    });

});

// Admin area
Route::name('admin.')->group(function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => 'auth',
    ], function () {
        //Dashboard
        Route::get('/', 'AdminController@index')->name('dashboard');

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

                Route::group(['prefix' => 'kelas/{kelas}'], function () {

                    Route::get('/edit', 'ClassroomController@edit')->name('edit');

                    Route::get('/pelajaran', 'ClassroomController@pelajaran');
                    Route::get('/pelajaran/assign', 'ClassroomController@assignPelajaran');
    
                    Route::get('/ujian', 'ClassroomController@ujian');
                    Route::get('/ujian/assign', 'ClassroomController@ujian');
    
    
                    Route::get('/anggota', 'ClassroomController@anggota');
                    Route::get('/anggota/assign', 'ClassroomController@anggota');
    
                    Route::get('/pengaturan', 'ClassroomController@pengaturan');
                    Route::post('/pengaturan', 'ClassroomController@pengaturan');

                });
                
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
