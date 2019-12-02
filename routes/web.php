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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/redirect/{provider}', 'Auth\LoginController@redirect')->name('login.provider');
Route::get('callback/{provider}', 'Auth\LoginController@callback')->name('login.callback');

Route::get('books', 'BookController@index')->name('books');
Route::get('books/{isbn}', 'BookController@show')->name('books.show');
