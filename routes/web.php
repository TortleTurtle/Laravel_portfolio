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
});

Route::get('/test', function () {
    $test = request('test');

    return view('test', [
        'test' => $test
    ]);
});

Route::get('/posts/create', 'postsController@create')->middleware('auth');
Route::get('/posts/{slug}', 'postsController@show');
Route::get('/posts/{slug}/edit', 'postsController@edit')->middleware('auth');
Route::put('/posts/{id}', 'postsController@update');
Route::post('/posts', 'postsController@store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');