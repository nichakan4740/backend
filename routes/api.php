<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MysugarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthAdmin;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\DrugInformationController;



use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;
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
Route::get('mysugars/{id}', [MysugarController::class, 'show']);

/* พยาบาล */
Route::post('nurse/register',[AuthAdmin::class, 'registerAdmin']);
Route::post('nurse/login',[AuthAdmin::class, 'loginAdmin']);
Route::post('nurse/logout',[AuthAdmin::class, 'logoutAdmin']);



/* ผู้ป่วย */
Route::post('patient/register',[AuthUser::class,'register']);
Route::post('patient/login', [AuthUser::class,'login']);
Route::post('patient/refresh', [AuthUser::class,'refresh']);
Route::post('patient/logout', [AuthUser::class,'logout']);


/* ข้อมูลยา */
Route::get('drug/{id}', [DrugInformationController::class,'showDrug']);
Route::post('drug', [DrugInformationController::class,'createDrug']);
Route::put('drug/{id}', [DrugInformationController::class,'updateDrug']);


/* get รายละเอียดผู้ป่วย  */
Route::get('patient/getProfile', [UserController::class,'indexuser']);
Route::get('patient/getProfile/{id}', [UserController::class,'showuserwithid']);
Route::delete('patient/getProfile/{id}', [UserController::class, 'destroyuser']);
Route::put('patient/getProfile/{id}', [UserController::class, 'updateuser']);



/* chat */
Route::get('/homechat', [HomeController::class, 'index']);

Auth::routes();




/* เพิ่ม */

    # routes/web.php
/*     Route::resource('groups', 'GroupController'); */
    Route::apiResource('/groups', GroupController::class);

    Route::apiResource('/conversations', ConversationController::class);


    Route::post('/conversations/{conversation}/reply', [ConversationController::class, 'reply']);


 






