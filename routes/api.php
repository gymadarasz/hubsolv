<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', 'BookController@index')->name('books.all');
Route::get('/books/filter', 'BookController@filter')->name('books.filter');
Route::get('/books/categories', 'BookController@categories')->name('books.categories');
Route::get('/books/add', 'BookController@store')->name('books.store');