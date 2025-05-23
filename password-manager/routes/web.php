<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\MasterPasswordController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth.session');

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [PasswordController::class, 'dashboard']);

    Route::get('/passwords/create', [PasswordController::class, 'create']);
    Route::post('/passwords', [PasswordController::class, 'store']);

    Route::get('/passwords/{password}/edit', [PasswordController::class, 'edit'])->name('passwords.edit');
    Route::put('/passwords/{password}', [PasswordController::class, 'update'])->name('passwords.update');

    Route::delete('/passwords/{password}', [PasswordController::class, 'destroy']);

    Route::get('/settings', [MasterPasswordController::class, 'edit'])->name('settings');
    Route::post('/settings', [MasterPasswordController::class, 'change'])->name('settings.update');

    Route::post('/change-master-password', [MasterPasswordController::class, 'change']);
});

