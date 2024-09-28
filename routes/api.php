<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlApiController;
use Illuminate\Http\Request;

// Public Authentication Routes
Route::post('/register', [AuthController::class, 'register']); // User registration
Route::post('/login', [AuthController::class, 'login']);       // User login

// Protected Routes (requires authentication)
Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user(); // Fetch the authenticated user
    });

    Route::post('/shorten', [UrlApiController::class, 'shorten']); // Shorten URL API
    Route::get('/statistics', [UrlApiController::class, 'statistics']); // Get statistics for URLs
    Route::post('/logout', [AuthController::class, 'logout']); // User logout
    Route::get('/profile', [AuthController::class, 'profile']); // Get user profile information
});