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

Auth::routes();
Route::get('auth/redirect/{provider}', 'Auth\LoginController@redirect')->name('login.provider');
Route::get('callback/{provider}', 'Auth\LoginController@callback')->name('login.callback');

Route::middleware('guest')->group(function () {
    Route::redirect('/', 'login');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', 'library');

    Route::prefix('library')->name('library')->group(function () {
        Route::get('/', 'LibraryController@index');
        Route::post('{book}', 'LibraryController@store')->name('.store');
        Route::delete('{book}', 'LibraryController@delete')->name('.delete');
    });
});

Route::prefix('books')->name('books')->group(function () {
    Route::get('/', 'BookController@index');
    Route::get('{book}', 'BookController@show')->name('.show');
});
