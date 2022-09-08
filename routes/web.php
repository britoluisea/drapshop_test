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

/*Route::get('/', function () {
    return view('welcome');
});*/
//cambiando ruta raiz por el login default
Route::get('/', function() {
    //validar si existe una session 
    if (Auth::check()){
        return view('layouts.mainLayout');
    }else{
        //sino mostrar login
        return view('auth.login');
    }
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/getUser', 'HomeController@getUser')->middleware('auth');

Route::get('/{any}', 'HomeController@index')
->name('home')
->middleware('auth')
->where('any', '.*');