<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('user_mobile_validate', [AuthController::class, 'user_mobile_validate']);
    Route::post('verify_otp', [AuthController::class, 'verify_otp']);
    Route::post('register', [AuthController::class, 'registration'])->middleware('auth:api');
});

Route::get('login', [AuthController::class, 'user_mobile_validate'])->name('login');
Route::get('locations', [AuthController::class, 'locations']);


Route::post('ads', [AdController::class, 'getAllAds']);
