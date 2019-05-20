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

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::get('/', function () {
        return view('home');
    })->name('admin.homepage');

    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::get('/users/import', 'UserController@showUserImport')->name('admin.users.showUserImport');
    Route::get('/users/export', 'UserController@showUserExport')->name('admin.users.showUserExport');
    Route::post('/users/export', 'UserController@exportUser')->name('admin.users.exportUser');
    Route::get('/users/create', 'UserController@create')->name('admin.users.showUserCreateForm');
    Route::get('/users/{id}', 'UserController@show')->name('admin.users.show');
    Route::post('/users/approve/{id}', 'UserController@approve')->name('admin.users.approve');
    Route::post('/users/edit/{id}', 'UserController@edit')->name('admin.users.editUser');
    Route::get('/users/import/template', 'UserController@importTemplate')->name('admin.users.template');

    Route::get('/admins', 'AdminController@index')->name('admin.admins.index');
    Route::get('/admins/create', 'AdminController@create')->name('admin.admins.create');
    Route::get('/admins/{id}', 'AdminController@show')->name('admin.admins.show');

    Route::get('/reports', 'ReportController@all')->name('admin.report.all');
    Route::get('/reports/export', 'ReportController@export')->name('admin.report.export');

    Route::get('/news', 'NewsController@index')->name('admin.news.index');
    Route::get('/news/create', 'NewsController@create')->name('admin.news.create');
    Route::post('/news/store', 'NewsController@store')->name('admin.news.store');
    Route::get('/news/{id}', 'NewsController@show')->name('admin.news.show');

    Route::get('/info', 'AdminController@detail')->name('admin.admins.detail');
    Route::get('/info/reset-password', 'AdminController@resetPassword')->name('admin.admins.reset.password');
});

Route::get('/home', function () {
    return redirect('/');
});

Auth::routes(['verify' => true]);
