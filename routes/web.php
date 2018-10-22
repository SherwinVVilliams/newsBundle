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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/superuser/login', 'Auth\LoginController@login');
Route::get('/superuser/login', 'Auth\LoginController@form');

Route::group(['middleware' => 'super'], function() {

	Route::get('/superuser/news', 'Admin\NewsController@All');
	Route::get('/superuser/news/edit/{id}', 'Admin\NewsController@Edit');
	Route::post('/superuser/news/edit', 'Admin\NewsController@Save');
	Route::get('/superuser/news/delete/{id}', 'Admin\NewsController@Delete');


	//BREAD

	Route::get('/superuser', 'Admin\NewsController@All');

	Route::get('/superuser/auth/logout', 'Auth\LoginController@logout');

	Route::post('/superuser/upload/image/{folder}/{size}', 'System\UploadController@upload');
	Route::delete('/superuser/upload/delete', 'System\UploadController@delete');

	Route::get('/superuser/upload/gallery/{folder}/{size}', 'System\UploadController@gallery');
	Route::get('/superuser/upload/gallery', 'System\UploadController@gallery');
});

Route::get('/news/{alias?}', 'Site\NewsController@index')->name('news')->where('alias', '[a-z]+');

