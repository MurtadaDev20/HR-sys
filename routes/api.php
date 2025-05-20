<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceVerificationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/verify-device', [DeviceVerificationController::class, 'verify']);
    Route::post('/trust-device', [DeviceVerificationController::class, 'trustDevice']);
});
