<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


    
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // روتات الأدمن هنا (المرحلة 3)
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    // روتات اليوزر هنا (المرحلة 3)
});

