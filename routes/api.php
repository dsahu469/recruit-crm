<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CandidateController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    // Routes accessible to unauthenticated users
    Route::middleware('guest')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    // Protected routes that require JWT authentication
    Route::middleware('jwt')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('token/refresh', [AuthController::class, 'refresh']);

        Route::post('candidates', [CandidateController::class, 'store']);
        Route::get('candidates/{id?}', [CandidateController::class, 'show']);
        Route::delete('candidates/{id?}', [CandidateController::class, 'delete']);
        Route::post('candidates/update/{id}', [CandidateController::class, 'update']);
        Route::post('candidates/search', [CandidateController::class, 'search']);

        Route::get('address/{id?}', [AddressController::class, 'show']);
        Route::post('address/', [AddressController::class, 'store']);

        Route::get('currency/{id?}', [CurrencyController::class, 'show']);
        Route::post('currency/', [CurrencyController::class, 'store']);
    });
});