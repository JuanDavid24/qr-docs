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

Route::get('/auth','GdeController@auth')->name('gde.auth');
Route::get('/doc/{any}','GdeController@validateDocument')->where('any', '.*')->name('gde.validateDocument');
// Route::get('doc/{numeroDocumeto}','GdeController@validateDocument')->name('gde.validateDocument');
