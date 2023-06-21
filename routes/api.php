<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\PaymentRecordController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// TODO: Vyřešit práva
//Route::post('/register', [AuthController::class, 'register']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//
//});

Route::get('/',  function () {
    return response()->json(['name' => config('app.name')]);
});

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    Route::get('user', [UserController::class, 'index']);
    Route::get('stats', [StatsController::class, 'index']);
    Route::apiResource('payers', PayerController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::prefix('payment-record/{paymentRecord}')->group(function () {
        Route::get('/', [PaymentRecordController::class, 'show']);
        Route::post('pay', [PaymentRecordController::class, 'pay']);
        Route::post('resend', [PaymentRecordController::class, 'resend']);
    });
});
