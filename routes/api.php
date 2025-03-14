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
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\SubscriptionController;

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
    Route::get('/get_user_details', [UserController::class, 'getUserDetails']);
    Route::post('/photo_action', [UserController::class, 'photoAction']);
    Route::post('profile_update', [AuthController::class, 'profile_update'])->name('profile_update');

    Route::get('/notification_preferences', [NotificationPreferenceController::class, 'notificationPreferences']);
    Route::post('/update_notification_status', [NotificationPreferenceController::class, 'updateNotificationStatus']);




Route::post('/activate-plan', [SubscriptionController::class, 'activatePlan']);
Route::get('view_user_plan', [SubscriptionController::class, 'viewUserPlan']);



});

Route::get('login', [AuthController::class, 'user_mobile_validate'])->name('login');
Route::get('locations', [AuthController::class, 'locations']);
Route::get('get_ads', [AdController::class, 'getAllAds']);
Route::get('get_plans', [PlanController::class, 'index']); 
Route::get('get_categories', [CategoryController::class, 'index']);
Route::get('get_contact_details', [AuthController::class, 'getFirstAdmin']);



Route::post('service_request', [JobRequestsController::class, 'RequestService']);
Route::post('update_service_request', [JobRequestsController::class, 'updateRequestService']);
Route::get('request_list', [JobRequestsController::class, 'requestList']);
Route::get('user_request_list', [JobRequestsController::class, 'userRequestList']);
Route::get('job_request_details', [JobRequestsController::class, 'jobRequestDetails']);