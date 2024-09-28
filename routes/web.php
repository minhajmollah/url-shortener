<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\StatisticsController;
// Home Route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// URL Shortener Routes


// URL Statistics (Protected by authentication)
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics')->middleware('auth');
Route::post('/shorten', [UrlController::class, 'store'])->name('urls.store')->middleware('auth');;
Route::get('/r/{code}', [UrlController::class, 'redirect'])->name('urls.redirect')->middleware('auth');;

Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);