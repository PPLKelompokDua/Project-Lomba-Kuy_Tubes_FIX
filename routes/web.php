<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompetitionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Competition;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🌐 Landing Page
Route::get('/', fn() => view('welcome'))->name('welcome');

// 🔐 Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🧠 Explore Public Competition (bisa diakses tanpa login)
Route::get('/explore', function () {
    $competitions = Competition::latest()->paginate(12);
    return view('competitions.explore', compact('competitions')); 
})->name('explore');

Route::get('/competitions/explore', [CompetitionController::class, 'explore'])->name('competitions.explore');

// Atau kalau kamu sudah punya controller, bisa pakai:
// Route::get('/explore', [CompetitionController::class, 'explore'])->name('explore');

// 🏠 Dashboard Role-Based
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');

        // Untuk user biasa
        $competitions = Competition::latest()->take(6)->get();
        return view('dashboard', compact('competitions'));
    })->name('dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Organizer Dashboard
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
    
    // Tambahan fitur organizer kalau ada (misalnya CRUD kompetisi)
    // Route::resource('organizer/competitions', OrganizerCompetitionController::class);
});