<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\BankDepositController;

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


Route::post('/recommendations', [RecommendationController::class, 'index']);
Route::post('/top-banks', [RecommendationController::class, 'topBanks']);
Route::post('/config', [App\Http\Controllers\Api\ConfigController::class, 'index']);

Route::post('/bank-deposits', [BankDepositController::class, 'index']);
Route::post('/bank-deposits-detail', [BankDepositController::class, 'bybank']);
