<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MysugarController;
use App\Http\Controllers\AuthAdmin;
use App\Http\Controllers\AuthUser;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('/mysugar', MysugarController::class);


/* Route::post('register/admin',[AuthAdmin::class, 'registerAdmin']);
Route::post('login/admin',[AuthAdmin::class, 'loginAdmin']); */


Route::post('register',[AuthUser::class,'register']);
Route::post('login', [AuthUser::class,'login']);
Route::post('refresh', [AuthUser::class,'refresh']);
Route::post('logout', [AuthUser::class,'logout']);


Route::post('admin/register',[AuthUser::class,'register']);
Route::post('admin/login', [AuthUser::class,'login']);
Route::post('admin/refresh', [AuthUser::class,'refresh']);
Route::post('admin/logout', [AuthUser::class,'logout']);