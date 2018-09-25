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
//    if (function_exists('xdebug_peak_memory_usage')) {
//        echo "Memory usage: " . round(xdebug_peak_memory_usage() / 1048576, 2) . 'MB';
//    }
//    $users = \App\User::query()->with('pageViews')->limit(10)->get();
//
//    \Cache::put('users', $users, 10);
//
//    $users = \Cache::get('users');

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/play', 'PlayController@index');