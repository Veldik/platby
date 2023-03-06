<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatsController;
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
    Route::get('stats', [StatsController::class, 'index']);
    Route::apiResource('payers', PayerController::class);
    Route::apiResource('payments', PaymentController::class);
});
