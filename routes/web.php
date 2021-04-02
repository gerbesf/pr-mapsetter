<?php

use Illuminate\Support\Facades\Route;

// Degustation
Route::get('/','\App\Http\Controllers\AdminController@index')->name('index');
Route::get('/confirmation','\App\Http\Controllers\AdminController@confirmation')->name('confirmation');
Route::post('/confirm','\App\Http\Controllers\AdminController@confirmMap')->name('confirm');

// Logged Maps
Route::get('/rotation','\App\Http\Controllers\AdminController@rotation')->name('rotation');

// History of maps
Route::get('/history','\App\Http\Controllers\AdminController@history')->name('history');

// Generic Logout
Route::get('/logout','\App\Http\Controllers\AdminController@logout')->name('logout');

// Admin Login
Route::get('/login','\App\Http\Controllers\AdminController@admin_login')->name('admin_login');
Route::post('/auth','\App\Http\Controllers\AdminController@admin_auth')->name('admin_auth');

Route::get('/ops',function (){
    echo 'Unauthorized';
});

// Master Panel
Route::group([
    #'middleware'=>['admin'],
    'prefix' => 'admin',
    'namespace'=>'\App\Http\Controllers'
],function(){
    Route::get('/','AdminController@admin')->name('admin');
    Route::get('/users','AdminController@admin_users')->name('admin_users');
    Route::get('/configure','AdminController@configure')->name('admin_configure');
    Route::get('/maplist','MaplistController@index')->name('admin_configure');
    Route::get('/map/{id}','MaplistController@details')->name('map_configure');
    Route::get('/maplist/update','MaplistController@update')->name('update_levels');
});
