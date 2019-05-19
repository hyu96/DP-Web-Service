<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/users', 'API\UserController@index')->name('api.users.index');
    Route::post('/users', 'API\UserController@store')->name('api.users.store');
    Route::post('/users/import', 'API\UserController@import')->name('api.users.import');
    Route::get('/users/export', 'API\UserController@export')->name('api.users.export');
    Route::get('/users/{id}', 'API\UserController@show')->name('api.users.show');
    Route::put('/users/{id}', 'API\UserController@edit')->name('api.users.edit');
    Route::delete('/users/{id}', 'API\UserController@delete')->name('api.users.delete');

	Route::get('/admins', 'API\AdminController@index')->name('api.admins.index');
    Route::post('/admins', 'API\AdminController@store')->name('api.admins.store');
    Route::put('/info', 'API\AdminController@editInfo')->name('api.admins.info.edit');
    Route::get('/info', 'API\AdminController@detail')->name('api.admins.info.detail');
    Route::put('/info/reset-password', 'API\AdminController@resetPassword')->name('api.admins.reset.password');
    Route::delete('/admins/{id}', 'API\AdminController@delete')->name('api.admins.delete');
    Route::get('/admins/{id}', 'API\AdminController@show')->name('api.admins.show');
    Route::put('/admins/{id}', 'API\AdminController@edit')->name('api.admins.edit');

	Route::get('/reports', 'API\ReportController@index')->name('api.reports.index');
    
	Route::get('/districts', 'API\DistrictController@index')->name('api.districts.index');
    Route::get('/districts/{id}', 'API\DistrictController@show')->name('api.districts.show');

    Route::get('/subdistricts', 'API\SubdistrictController@index')->name('api.subdistrict.index');
});
