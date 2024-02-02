<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AuthAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API admins routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


 


    Route::middleware(['auth:admin'])->group(function () {
        Route::get('view',[TestAuth::class, 'index']);
    });
