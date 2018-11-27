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

Route::get('/uploadFile', 'UserController@UploadFile')->name('uploadFile');
Route::post('/uploadFile', 'UserController@Treatment')->name('uploadFile');
Route::get('/files','UserController@files')->name('allFiles');
Route::get('/top/{id}','UserController@top')->name('top');