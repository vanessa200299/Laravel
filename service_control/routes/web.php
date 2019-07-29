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

Route::get('/','HomeController@index');
Route::post('/registrar','HomeController@registrarUsuario');
Route::post('/login','HomeController@login');
Route::get('/services','HomeController@services');
Route::post('/addService','HomeController@addService');
Route::post('/updateService','HomeController@updateService');
Route::post('/deleteService','HomeController@deleteService');
Route::get('/admin','HomeController@admin');
Route::post('/switchUser','HomeController@switchStatusUser');

Route::get('/webServiceUsers','HomeController@webServiceUsers');

Route::middleware('usuarioactivo')->group(function () {
	Route::get('/redirect','HomeController@redirect');
});