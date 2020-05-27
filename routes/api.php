<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'API\\AuthController@login')->name('login');
    Route::post('logout', 'API\\AuthController@logout');
    Route::post('refresh', 'API\\AuthController@refresh');
    Route::post('me', 'API\\AuthController@me');
    Route::get('unauthenticated', 'API\\AuthController@unauthenticated')->name('authenticate');

});

Route::resource('products', 'API\\ProductController')->except(['edit', 'create']);
Route::resource('users', 'API\\UserController')->except(['edit', 'create', 'index']);


