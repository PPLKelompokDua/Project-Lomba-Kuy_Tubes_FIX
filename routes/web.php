<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductivityController;

// Landing Page
Route::get('/', fn() => view('welcome'))->name('welcome');

// Login and Register Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');
        return view('dashboard');
    })->name('dashboard');

    // Admin and Organizer Dashboards
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
    
    // Task Management Routes
    Route::get('/task-management', [TaskController::class, 'index'])->name('task.management');
    Route::resource('tasks', TaskController::class);
    
    // Team Productivity Graph - Using auth middleware only
    Route::middleware(['auth'])->group(function () {
        Route::get('/team-productivity', [ProductivityController::class, 'index'])->name('team.productivity');
    });

    // Export Report
    Route::get('/productivity/data', [ProductivityController::class, 'getProductivityData'])->name('productivity.data');
    Route::post('/productivity/export', [ProductivityController::class, 'exportReport'])->name('productivity.export');
    Route::post('/productivity/share', [ProductivityController::class, 'shareReport'])->name('productivity.share');
    
});