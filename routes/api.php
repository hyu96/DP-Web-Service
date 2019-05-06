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

	Route::get('/admins', 'API\AdminController@index')->name('api.admins.index');

	Route::get('/reports', 'API\ReportController@index')->name('api.reports.index');

	Route::get('/districts', 'API\DistrictController@index')->name('api.districts.index');
    Route::get('/districts/{id}', 'API\DistrictController@show')->name('api.districts.show');

    Route::get('/subdistricts', 'API\SubdistrictController@index')->name('api.subdistrict.index');
});
