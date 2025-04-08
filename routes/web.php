<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Competition;

// Halaman Welcome (Landing Page)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Halaman Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Halaman Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman Registrasi
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');


// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard'); // pastikan file ini ada: resources/views/user/dashboard.blade.php
    })->name('dashboard');

    Route::get('/organizer/dashboard', function () {
        return view('organizer.dashboard'); // pastikan ini juga ada
    })->name('organizer.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // pastikan ini juga
    })->name('admin.dashboard');
});

// Rute untuk kompetisi
Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');


// Organizer route group
Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::resource('competitions', \App\Http\Controllers\Organizer\CompetitionController::class);
});



// Testing organizer crud eksplorasi lomba

Route::get('/test/organizer-competitions', function () {
    $organizerId = 2; // ID user organizer
    $competitions = Competition::where('organizer_id', $organizerId)->get();

    return view('organizer.competitions.index', compact('competitions'));
});
