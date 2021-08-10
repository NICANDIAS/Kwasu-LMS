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

Route::match(['post','get'], 'signUp', 'signUpsController@create');
Route::match(['post','get'], 'application', 'LeaveController@index');
Route::get('allLeave', 'LeaveController@show');
Route::match(['post','get'], 'applied', 'LeaveController@applied');
Route::match(['post','get'], 'approval/{id}', 'LeaveController@approval');
Route::get('approved', 'LeaveController@getApprovedLeave');
Route::match(['post','get'], 'editApplication/{id}/', 'LeaveController@edit');

//Leave Faculty
Route::match(['post','get'], 'faculty', 'FacultyController@create');
Route::match(['post','get'], 'editFaculty/{id}/edit', 'FacultyController@edit');
Route::match(['post','get'], 'deleteFaculty/{id}/delete', 'FacultyController@destroy');

//Leave Department
Route::match(['post','get'], 'department', 'DepartmentController@create');
Route::match(['post','get'], 'editDepartment/{id}/edit', 'DepartmentController@edit');
Route::match(['post','get'], 'deleteDepartment/{id}/delete', 'DepartmentController@destroy');

//Leave Unit
Route::match(['post','get'], 'unit', 'UnitController@create');
Route::match(['post','get'], 'editUnit/{id}/edit', 'UnitController@edit');
Route::match(['post','get'], 'deleteUnit/{id}/delete', 'UnitController@destroy');

//Leave Type
Route::match(['post','get'], 'leaveType', 'leaveTypeController@create');
Route::match(['post','get'], 'editLeaveType/{id}/edit', 'leaveTypeController@edit');
Route::match(['post','get'], 'leaveType/{id}/delete', 'leaveTypeController@destroy');

//Holidays
Route::match(['post','get'], 'holiday', 'HolidayController@index');
Route::match(['post','get'], 'holiday', 'HolidayController@create');
Route::match(['post','get'], 'editHoliday/{id}/edit', 'HolidayController@edit');
Route::match(['post','get'], 'holiday/{id}/delete', 'HolidayController@destroy');

//Leave View Details
Route::get('leaveViewDetails/{employee_id}/{id}', 'LeaveController@getleaveViewDetails');

Route::match(['post','get'],'search', 'signUpsController@show');
