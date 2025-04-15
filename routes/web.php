<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// Halaman Landing
Route::get('/', fn() => view('welcome'))->name('welcome');

// Halaman Login dan Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

 // TEAM CRUD
 Route::resource('teams', TeamController::class);

 // TEAM MEMBER (optional)
 Route::put('/team-members/{member}/role', [TeamMemberController::class, 'updateRole']);
 Route::delete('/team-members/{member}', [TeamMemberController::class, 'destroy']);

 // INVITATION
 Route::post('/teams/{teamId}/invitations', [InvitationController::class, 'send']);
 Route::get('/teams/{teamId}/invitations', [InvitationController::class, 'track']);
 Route::put('/invitations/{invitation}', [InvitationController::class, 'respond']);
 Route::get('/invitations', [InvitationsController::class, 'index'])->name('invitations.index');
 Route::post('/invitations/send', [InvitationsController::class, 'send'])->name('invitations.send');

 // CHAT
 Route::get('/messages', [MessageController::class, 'index']);
 Route::post('/messages', [MessageController::class, 'send']);

 // RECOMMENDATION
 Route::get('/recommendations', [RecommendationController::class, 'index']);

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
});
