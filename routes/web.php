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

//post routes
Route::get('/posts', 'postsController@index');
Route::get('/posts/create', 'postsController@create')->middleware('permissions');
Route::get('/posts/{slug}', 'postsController@show');
Route::get('/posts/{slug}/edit', 'postsController@edit')->middleware('permissions');
Route::put('/posts/{id}', 'postsController@update')->middleware('permissions');
Route::post('/posts', 'postsController@store')->middleware('permissions');

Route::get('/permissions', 'postsController@checkPermissions')->middleware('auth', 'permissions');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');