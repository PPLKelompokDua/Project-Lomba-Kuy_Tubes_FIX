<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\Organizer\CompetitionController as OrganizerCompetitionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Competition;

// 🌐 Landing Page
Route::get('/', fn() => view('welcome'))->name('welcome');

// 🔐 Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔍 Public Explore (tanpa login)
Route::get('/explore', [CompetitionController::class, 'explore'])->name('explore');
Route::get('/competitions/explore', [CompetitionController::class, 'explore'])->name('competitions.explore');

// 🔐 Protected Routes (role-based dashboard)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard redirect sesuai role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');

        $competitions = Competition::latest()->take(6)->get();
        return view('dashboard', compact('competitions'));
    })->name('dashboard');

    // Admin
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Organizer
    Route::get('/organizer/dashboard', [OrganizerCompetitionController::class, 'index'])->name('organizer.dashboard');
    
    Route::prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', OrganizerCompetitionController::class)->except(['index']);
    });
    Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', OrganizerCompetitionController::class);
    });
});
