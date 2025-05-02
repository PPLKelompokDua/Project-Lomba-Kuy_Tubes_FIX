<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Auth;

// Halaman Landing
Route::get('/', fn() => view('welcome'))->name('welcome');

// Halaman Login dan Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

 // TEAM CRUD
 


  // Invitations
Route::prefix('invitation')->group(function () {
Route::resource('invitation', InvitationController::class);
Route::post('invitation/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('invitation/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
Route::delete('invitation/{invitation}', [InvitationController::class, 'cancel'])->name('invitations.cancel');
Route::get('invitation/team/{team}', [InvitationController::class, 'trackTeamInvitations'])->name('invitations.team');
Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
Route::get('/invitations/{invitation}', [InvitationController::class, 'show'])->name('invitations.show');



});

Route::resource('invitations', \App\Http\Controllers\invitationController::class);
Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

 // Messages
 Route::prefix('messages')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/user/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/send', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/invitation/{invitation}', [MessageController::class, 'invitationMessages'])->name('messages.invitation');
});
 // Competitions
 Route::resource('competitions', CompetitionController::class)->only(['index', 'show']);
    
 // Events
 Route::resource('events', EventController::class)->only(['index', 'show']);
 
 // Forum
 Route::resource('forum', ForumController::class);

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
