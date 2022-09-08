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

Auth::routes();
// llamar datos de login
Route::get('/getUser', 'UserController@getUser')->middleware('auth');
Route::post('/changePass', 'UserController@changePass')->middleware('auth');
//cambiando ruta raiz por el login default
Route::get('/', function() {return view('auth.login');}); 
//validar si existe una session 
Route::get('/{any}', 'HomeController@index')
->name('home')
->middleware('auth')
->where('any', '.*');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

