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

Route::get('/','\App\Http\Controllers\AdminController@index');
Route::get('/history','\App\Http\Controllers\AdminController@history');

Route::get('/login','\App\Http\Controllers\AdminController@login');
Route::post('/auth','\App\Http\Controllers\AdminController@auth');
Route::get('/logout','\App\Http\Controllers\AdminController@logout');

Route::group([
    'middleware'=>['admin'],
    'prefix' => 'admin',
    'namespace'=>'\App\Http\Controllers'
],function(){
    Route::get('/','AdminController@admin')->name('admin');
    Route::get('/configure','AdminController@configure');
    Route::get('/maplist','MaplistController@index');
    Route::get('/maplist/update','MaplistController@update')->name('update_levels');
});
