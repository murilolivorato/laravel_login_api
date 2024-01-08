<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
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

Route::post('/post-login',  [AuthUserController::class, 'postLogin']);
Route::group(['middleware' => ['auth:api']] , function () {
    Route::post('/logout', [AuthUserController::class, 'logout']);
    Route::post('/user-info', [AuthUserController::class, 'userInfo']);
});
