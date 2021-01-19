<?php

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
Route::view('/', 'welcome');

Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');



Route::get('/login/employee', 'Auth\LoginController@showEmployeeLoginForm');
Route::post('/login/employee', 'Auth\LoginController@EmployeeLogin');
Route::get('/register/employee', 'Auth\RegisterController@showEmployeeRegisterForm');
Route::post('/register/employee', 'Auth\RegisterController@createEmployee');

Route::group(['middleware' => ['IsEmployee']], function() {
    Route::view('/home', 'home')->middleware('auth');
    Route::resource('/employees', 'admin\EmployeesController');
    Route::any('/logout/employee', function () {
        Auth::guard('employee')->logout();
        return redirect()->guest('/login/employee');
    });
});

Route::group(['middleware' => ['IsAdmin']], function() {
    Route::view('/admin', 'admin');
    Route::any('/logout/admin', function () {
        Auth::guard('admin')->logout();
        return redirect()->guest('/login/admin');
    });
    Route::get('employees-export', 'admin\EmployeesController@export')->name('employees-export');
    Route::view('/employee', 'employee');
});
