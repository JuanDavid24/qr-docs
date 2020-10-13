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
    return view('index');
});

// Route::get('/doc/{any}','GdeController@validateDocument')->where('any', '.*')->name('gde.validateDocument');
Route::get('/doc/{any}','FrontController@index')->where('any', '.*')->name('index');
Route::get('/','FrontController@index')->name('index');
Route::post('/consulta','FrontController@consulta')->name('consulta');
Route::post('/consulta/pdf','FrontController@verPdf')->name('verPdf');

// catch all routes
Route::fallback(function () {
    return redirect('/');
});
