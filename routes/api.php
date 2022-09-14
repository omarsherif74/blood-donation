<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post("admin/login", [AdminController::class, 'login'])->name('admin.login');
Route::post("admin/signup", [AdminController::class, 'signup'])->name('admin.signup');
Route::get("admin/list_users", [AdminController::class, 'list_users']);
Route::get("admin/list_banks", [AdminController::class, 'list_banks']);
