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

/*Route::get('/', function () {
    return view('index');
});*/


Auth::routes();

Route::get('/', 'ArtistsController@index');
Route::get('/new', 'NewController@index')->name('new');
Route::post('/new', 'NewController@save')->name('save');
Route::get('/{artist}', 'ArtistController@index');
Route::get('/{artist}/{id}', 'AlbumController@index');