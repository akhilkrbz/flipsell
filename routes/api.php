<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobRequestsController;

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
    Route::post('job_requests', [JobController::class, 'jobRequests'])->name('job_requests');
    Route::post('/get_job_details', [JobController::class, 'getJobDetails']);
    Route::post('/get_user_details', [UserController::class, 'getUserDetails']);
    Route::post('/photo_action', [UserController::class, 'photoAction']);

});

Route::get('login', [AuthController::class, 'user_mobile_validate'])->name('login');
Route::get('locations', [AuthController::class, 'locations']);
Route::post('get_ads', [AdController::class, 'getAllAds']);
Route::post('get_plans', [PlanController::class, 'index']); 
Route::post('get_categories', [CategoryController::class, 'index']);
Route::post('get_contact_details', [AuthController::class, 'getFirstAdmin']);



Route::post('service_request', [JobRequestsController::class, 'RequestService']);