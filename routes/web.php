<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\Organizer\CompetitionController as OrganizerCompetitionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Competition;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;

// 🌐 Landing Page
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 🔐 Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/search-suggestions', [CompetitionController::class, 'searchSuggestions']);

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
        $user = auth()->user(); // ambil user sekarang
    
        // Tambahan menghitung saved
        $savedCompetitions = $user->savedCompetitions()->count(); 
    
        // Tambahan menghitung active dan completed competitions (dummy dulu 0)
        $activeCompetitions = 0; // kalau belum ada fitur lomba aktif
        $completedCompetitions = 0; // kalau belum ada fitur lomba selesai
    
        return view('dashboard', compact('competitions', 'savedCompetitions', 'activeCompetitions', 'completedCompetitions', 'user'));
    })->name('dashboard');

    // Admin
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });
    Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', \App\Http\Controllers\Organizer\CompetitionController::class);
    });


    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::put('/settings', [ProfileController::class, 'settingsUpdate'])->name('settings.update');
        Route::delete('/settings', [ProfileController::class, 'delete'])->name('settings.delete');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password/edit', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
    
    // Organizer
    Route::get('/organizer/dashboard', [OrganizerCompetitionController::class, 'index'])->name('organizer.dashboard');
    
    Route::prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', OrganizerCompetitionController::class)->except(['index']);
    });
    Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', OrganizerCompetitionController::class);
    });

    //Bookmarks
    Route::middleware(['auth'])->group(function () {
        // Bookmark actions
        Route::post('/competitions/{competition}/save', [CompetitionController::class, 'save'])->name('competitions.save');
        Route::delete('/competitions/{competition}/unsave', [CompetitionController::class, 'unsave'])->name('competitions.unsave');
    
        // 🔥 Tambahkan ini untuk halaman list bookmark
        Route::get('/saved-competitions', [CompetitionController::class, 'saved'])->name('competitions.saved');
    });
    
    // Untuk lihat detail kompetisi
    Route::get('/competitions/{competition}', [CompetitionController::class, 'show'])->name('competitions.show');

    // Untuk cari anggota tim random
    Route::get('/competitions/{competition}/random-members', [CompetitionController::class, 'randomMembers'])->name('competitions.random-members');

    

});
