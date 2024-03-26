<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MysugarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthAdmin;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\DrugInformationController;
use App\Http\Controllers\InformationUserController;



use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;

use App\Http\Controllers\AdminController;




/* Test */
use App\Http\Controllers\Controller;

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
Route::post('savedrug', [DrugInformationController::class,'createDrug']);
Route::put('drug/{id}', [DrugInformationController::class,'updateDrug']);
//เช็คข้อมูลยา 
// Route::get('/check-drug-information', 'DrugInformationController@checkDrugInformation');
Route::get('/check-data/{id}', [DrugInformationController::class, 'checkDrugInformation']);


// ข้อมูลผู้ป่วย
Route::put('updateinfo', [InformationUserController::class,'updateinfouser']);
Route::get('info/{id}', [InformationUserController::class,'showinfo']);


/* get รายละเอียดผู้ป่วย  */
Route::get('patient/getProfile', [UserController::class,'indexuser']);
Route::get('patient/getProfile/{id}', [UserController::class,'showuserwithid']);
Route::delete('patient/getProfile/{id}', [UserController::class, 'destroyuser']);
Route::put('patient/getProfile/{id}', [UserController::class, 'updateuser']);


/* get รายละเอียดพยาบาล */
Route::get('nurse/getProfile', [AdminController::class,'indexuser']);
Route::get('nurse/getProfile/{id}', [AdminController::class,'showuserwithid']);
Route::delete('nurse/getProfile/{id}', [AdminController::class, 'destroyuser']);
Route::put('nurse/getProfile/{id}', [AdminController::class, 'updateuser']);







    /* chat */
    Route::post('/conversations', [ConversationController::class, 'store']);
    /* ตอบกลับข้อความ */
    Route::post('/reply/user', [ConversationController::class, 'AdminReplysUser']); // เส้นทางสำหรับตอบกลับ conversation
    Route::post('/reply/admin', [ConversationController::class, 'UserReplysAdmin']); // เส้นทางสำหรับตอบกลับ conversation
   

    Route::delete('/messages/{messageId}', [ConversationController::class ,'deleteMessage']);
    Route::post('/testchat', [Controller::class, 'TestChat']);







