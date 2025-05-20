<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VacationApprovalController;
use App\Http\Controllers\VacationRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Dashboard route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/fingerprint/attendance', [AttendanceController::class, 'markAttendance'])->name('fingerprint.attendance');
    Route::get('/vacation-request', [VacationRequestController::class, 'index'])->name('vacation-request');
    Route::post('/vacation-request', [VacationRequestController::class, 'store'])->name('vacation-request.store');

    Route::get('/vacation-approval', [VacationApprovalController::class, 'index'])->name('vacation-approval');
});
