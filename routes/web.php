<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@entry');

Auth::routes();

// Front area
Route::group(['namespace' => 'Front', 'middleware' => 'auth'], function (){

    // Dashboard
    Route::get('/dashboard', 'FrontController@index')->name('dashboard');

    Route::group(['prefix' => 'k'], function () {

        Route::redirect('/{kelas:kode}', '/k/{kelas:kode}/depan');

        // Classroom's subpage
        Route::group(['prefix' => '/{kelas:kode}'], function () {
            Route::get('/depan', 'ClassroomController@showHome')->name('kelas.home');
            Route::get('/pelajaran', 'ClassroomController@showLessons')->name('kelas.lessons');
            Route::get('/works', 'ClassroomController@showWorks')->name('kelas.works');
            Route::get('/anggota', 'ClassroomController@showPeople')->name('kelas.people');            
        });

        // Exam's subpage
        Route::group(['prefix' => '/{kelas:kode}/u/'], function () {
            Route::get('{exam:slug}', 'ClassroomExamController@showInfo')->name('kelas.exam.info');
            Route::get('{exam:slug}/kerjakan', 'ClassroomExamController@showExam')->name('kelas.exam.kerjakan');
            Route::get('{exam:slug}/riwayat', 'ExamResultController@showHistory')->name('kelas.exam.riwayat-user');
            Route::get('{exam:slug}/hasil', 'ExamResultController@showResult')->name('kelas.exam.hasil-user');

        });

    });

});

// Admin area
Route::name('admin.')->group(function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'admin'],
    ], function () {
        //Dashboard
        Route::get('/', 'AdminController@index')->name('dashboard');

        // Lessons
        // Sections => Ganti jadi unit
        // Route::get('pelajaran/{pelajaran}/section/{section}/ujian/assign', 'SectionController@listUnassignedExam');
        // Route::resource('pelajaran/{pelajaran}/section', 'SectionController'); 

        Route::resource('pelajaran', 'LessonController');
        
        // Questions
        Route::resource('soal', 'QuestionController');

        // Exam
        Route::get('ujian/{ujian}/kelas', 'ExamController@showClassrooms')->name('ujian.kelas');
        Route::get('ujian/{ujian}/detail', 'ExamController@showUserResult')->name('ujian.detail');

        Route::resource('ujian', 'ExamController');
        
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
                });
                
            });
        });

        // Groups
        Route::resource('grup', 'GroupController');
    
        // Users
        Route::post('user/process-csv', 'UserController@processCsv')->name('user.processCsv');
        
        Route::get('user/import-csv', 'UserController@getCsv')->name('user.getCsv');
        Route::post('user/parse-csv', 'UserController@parseCsv')->name('user.parseCsv');
        Route::get('/user/preview-csv', 'UserController@previewCsvData')->name('user.previewCsv');

        Route::resource('user', 'UserController');
    
        // Setting
        Route::resource('setting', 'SettingController')->only(['index', 'store']);
    
    });
});
