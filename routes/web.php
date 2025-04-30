<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController; // Add
 use App\Http\Controllers\Organizer\TaskControllerOrganizer; 
use Illuminate\Support\Facades\Auth;

// Halaman Landing
Route::get('/', fn() => view('welcome'))->name('welcome');

// Halaman Login dan Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routing Berdasarkan Role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');

        return view('dashboard'); // User biasa
    })->name('dashboard');

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
    Route::get('/task-management', [TaskController::class, 'index'])->name('task.management');
    Route::resource('tasks', TaskController::class);
});

 // Hapus duplikasi route group dan perbaiki definisi resource
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');
        return view('dashboard');
    })->name('dashboard');

    // Admin dan Organizer Routes
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
    
    // Task Routes
    Route::get('/task-management', [TaskController::class, 'index'])->name('task.management');
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
});
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');


// Di dalam middleware auth group
Route::middleware(['auth', 'check.role.organizer'])->prefix('organizer')->group(function () {
    // Dashboard organizer
    Route::get('/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
    
    // Task routes untuk organizer
    Route::resource('tasks', TaskControllerOrganizer::class)->names([
        'index' => 'organizer.tasks.index',
        'store' => 'organizer.tasks.store',
        'destroy' => 'organizer.tasks.destroy',
        'show' => 'organizer.tasks.show'
    ]);
    
    Route::get('/task-management', [TaskControllerOrganizer::class, 'index'])->name('organizer.task.management');
});
Route::prefix('organizer')->middleware(['auth', 'role:organizer'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

// Add this inside auth middleware group
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/team-productivity', function () {
        return view('graphic');
    })->name('team.productivity');
});


