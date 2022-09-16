<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

Route::post("admin/signup", [AdminController::class, 'signup']);
Route::post("admin/login", [AdminController::class, 'login']);
Route::get("admin/list_users", [AdminController::class, 'list_users']);
Route::get("admin/list_banks", [AdminController::class, 'list_banks']);


Route::get('user/', [UserController::class, 'index']);
Route::post('user/signup', [UserController::class, 'signup']);
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/donate/{user_id}', [UserController::class, 'donate']);
Route::post('user/request/{user_id}', [UserController::class, 'request']);
Route::get('user/show_history/{user_id}', [UserController::class, 'show_history']);
