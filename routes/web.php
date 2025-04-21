<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\CheckRole;
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

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard')
        ->middleware(CheckRole::class . ':admin');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard')
        ->middleware(CheckRole::class . ':organizer');
    
    // Public Competitions List - available to both authenticated and guest users
    Route::get('/competitions/public', [CompetitionController::class, 'public'])->name('competitions.public');
    
    // Competition Routes
    Route::prefix('competitions')->name('competitions.')->middleware('auth')->group(function () {
        // Routes for all authenticated users
        Route::get('/', [CompetitionController::class, 'index'])->name('index');
        Route::get('/{id}/random-members', [CompetitionController::class, 'findRandomMembers'])->name('random-members');
        Route::get('/{id}', [CompetitionController::class, 'show'])->name('show');
        
        // Routes for organizers and admins only
        Route::middleware(CheckRole::class . ':organizer,admin')->group(function () {
            Route::get('/create/new', [CompetitionController::class, 'create'])->name('create');
            Route::post('/', [CompetitionController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CompetitionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CompetitionController::class, 'update'])->name('update');
            Route::delete('/{id}', [CompetitionController::class, 'destroy'])->name('destroy');
        });
    });
    
    // Registration Routes
    Route::prefix('registrations')->name('registrations.')->middleware('auth')->group(function () {
        // Routes for all authenticated users
        Route::get('/', [RegistrationController::class, 'index'])->name('index');
        Route::get('/{id}', [RegistrationController::class, 'show'])->name('show');
        
        // Routes for creating registrations (all users)
        Route::get('/create', [RegistrationController::class, 'create'])->name('create');
        Route::post('/', [RegistrationController::class, 'store'])->name('store');
        
        // Routes for editing own registrations (students/users)
        Route::get('/{id}/edit', [RegistrationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RegistrationController::class, 'update'])->name('update');
        Route::delete('/{id}', [RegistrationController::class, 'destroy'])->name('destroy');
        
        // Routes for organizers and admins to manage registrations
        Route::middleware(CheckRole::class . ':organizer,admin')->group(function () {
            Route::post('/{id}/approve', [RegistrationController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [RegistrationController::class, 'reject'])->name('reject');
        });
    });
});
