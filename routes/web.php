<?php

use GuzzleHttp\Promise\Create;
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

Auth::routes();
Route::get('/', 'homeController@index');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['post','get'],'signUp', 'signUpsController@create');
Route::match(['post','get'],'application', 'LeaveController@index');
Route::get('allLeave', 'LeaveController@show');
Route::match(['post','get'],'applied', 'LeaveController@applied');
Route::match(['post','get'],'approval/{id}', 'LeaveController@approval');
