<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FirebaseNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('welcome');
});


//Firebase
Route::get('/send_notification', [FirebaseNotificationController::class, 'sendNotification']);