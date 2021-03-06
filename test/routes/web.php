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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/empleado', 'HomeController@empleado');
Route::post('/empleado/store', 'HomeController@store');
Route::put('/empleado/desactivar', 'HomeController@desactivar');
Route::put('/empleado/activar', 'HomeController@activar');
Route::put('/empleado/elimina', 'HomeController@elimina');