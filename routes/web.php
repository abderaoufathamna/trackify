<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ModuleController as UserModuleController;
use App\Http\Controllers\User\AttendanceController as UserAttendanceController;
use App\Http\Controllers\User\SubscriptionController as UserSubscriptionController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check())
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
            return redirect()->route('user.dashboard');
    }
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);

        Route::resource('students', AdminStudentController::class)->only(['index']);

        Route::resource('modules', AdminModuleController::class)->only(['index', 'create', 'store']);

        Route::resource('subscriptions', AdminSubscriptionController::class)
            ->only(['index', 'edit', 'update', 'destroy']);

        Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');
    });

/*
|--------------------------------------------------------------------------
| User (Student) Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('modules', UserModuleController::class)->only(['create', 'store']);

        Route::resource('attendance', UserAttendanceController::class)->only(['index', 'store']);

        Route::resource('subscriptions', UserSubscriptionController::class)->except(['show']);
    });