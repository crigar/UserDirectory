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



Route::group(['prefix' => 'users'], function() {
    Route::get('/index', 'UserController@index');
    Route::post('/create', 'UserController@store');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout');
    Route::post('/search', 'UserController@search');
    Route::post('/update', 'UserController@update');
    Route::get('/document/{document}', 'UserController@showUserById');
    Route::get('/remove-users', 'UserController@removeAll');
    Route::get('/destroy/{id}', 'UserController@destroy');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
