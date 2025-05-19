<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;


Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [PasswordController::class, 'dashboard']);
    Route::get('/passwords/create', [PasswordController::class, 'create']);
    Route::post('/passwords', [PasswordController::class, 'store']);
    Route::delete('/passwords/{password}', [PasswordController::class, 'destroy']);
});


Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [PasswordController::class, 'dashboard']);
});


Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [PasswordController::class, 'dashboard']);
    Route::get('/passwords/create', [PasswordController::class, 'create']);
    Route::post('/passwords', [PasswordController::class, 'store']);
    Route::delete('/passwords/{password}', [PasswordController::class, 'destroy']);
});

