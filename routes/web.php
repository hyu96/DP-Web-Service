<?php

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

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', function () {
        return view('home');
    })->name('admin.homepage');

    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::get('/users/import', 'UserController@showUserImport')->name('admin.users.showUserImport');
    Route::post('/users/import', 'UserController@importUser')->name('admin.users.importUser');
    Route::get('/users/export', 'UserController@showUserExport')->name('admin.users.showUserExport');
    Route::post('/users/export', 'UserController@exportUser')->name('admin.users.exportUser');
    Route::get('/users/create', 'UserController@create')->name('admin.users.showUserCreateForm');
    Route::get('/users/{id}', 'UserController@show')->name('admin.users.show');
    Route::post('/users/approve/{id}', 'UserController@approve')->name('admin.users.approve');
    Route::post('/users/edit/{id}', 'UserController@edit')->name('admin.users.editUser');

    Route::get('/admins', 'AdminController@index')->name('admin.admins.index');
    Route::get('/admins/create', 'AdminController@create')->name('admin.admins.create');
    Route::post('/admins/register', 'Auth\RegisterController@create')->name('admin.admins.register');

    Route::get('/reports', 'ReportController@all')->name('admin.report.all');

    Route::get('/news', 'NewsController@index')->name('admin.news.index');
    Route::get('/news/create', 'NewsController@create')->name('admin.news.create');
    Route::post('/news/store', 'NewsController@store')->name('admin.news.store');
    Route::get('/news/{id}', 'NewsController@show')->name('admin.news.show');
});

Route::get('/home', function () {
    return redirect('/');
});

Auth::routes();
