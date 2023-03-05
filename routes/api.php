<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PayerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// TODO: Vyřešit práva
//Route::post('/register', [AuthController::class, 'register']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//
//});

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    Route::get('user', [UserController::class, 'index']);
    Route::apiResource('payers', PayerController::class);
    Route::apiResource('payments', PaymentController::class);
});
