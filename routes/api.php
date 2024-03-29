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
Route::get('/categories', 'CategoryController@index')->name('books.all');
Route::get('/books/filter', 'BookController@filter')->name('books.filter');
Route::post('/books/add', 'BookController@store')->name('books.store');
Route::get('/book/{isbn}', 'BookController@filter')->name('books.filter');
