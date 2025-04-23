<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TeamsMemberController;
use Illuminate\Support\Facades\Auth;

// Halaman Landing
Route::get('/', fn() => view('welcome'))->name('welcome');

// Halaman Login dan Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

 // TEAM CRUD
 Route::resource('teams', TeamsController::class);

 // TEAM MEMBER (optional)
 Route::put('/team-members/{member}/role', [TeamsMemberController::class, 'updateRole']);
 Route::delete('/team-members/{member}', [TeamsMemberController::class, 'destroy']);

 // INVITATION
 Route::post('/teams/{teamId}/invitations', [InvitationsController::class, 'send']);
 Route::get('/teams/{teamId}/invitations', [InvitationsController::class, 'track']);
 Route::put('/invitations/{invitation}', [InvitationsController::class, 'respond']);
 Route::get('/invitations', [InvitationsController::class, 'index'])->name('invitations.index');
 Route::post('/invitations/send', [InvitationsController::class, 'send'])->name('invitations.send');
 Route::resource('invitations', InvitationsController::class);
 // CHAT
 Route::get('/messages', [MessagesController::class, 'index']);
 Route::post('/messages', [MessagesController::class, 'send']);

 // RECOMMENDATION
 Route::get('/recommendations', [RecommendationsController::class, 'index']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routing Berdasarkan Role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth();
        $user = auth();

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');

        return view('dashboard'); // User biasa
    })->name('dashboard');

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');
});
