<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

Route::controller(UserController::class)->group(function () {
    Route::get('user', 'index')->name('user.index');
    Route::get('user/register', 'register')->name('user.register');
    Route::get('user/login', 'login')->name('user.login');
    Route::get('user/request', 'request')->name('user.request');
    Route::get('user/donate', 'donate')->name('user.donate');
    Route::get('user/show_history', 'show_history')->name('user.show_history');
});

//Route::resource('admin', AdminController::class);

Route::controller(AdminController::class)->group(function () {
    Route::get('admin', 'index')->name('admin.index');
    Route::get('admin/show_users', 'show_users')->name('admin.show_users');
    Route::get('admin/show_banks', 'show_banks')->name('admin.show_banks');
});
