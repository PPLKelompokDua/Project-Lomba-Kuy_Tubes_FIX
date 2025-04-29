<?php

use App\Http\Controllers\UserController;
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

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routing Berdasarkan Role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');
        // if ($role === 'user') return dd('user');

        return view('dashboard'); // User biasa
    })->name('dashboard');
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/organizer/dashboard', fn() => view('organizer.dashboard'))->name('organizer.dashboard');

    Route::get('/competitions/my-list-experiance',[UserController::class,'CompetitionUser'])->name('list-competition-user');
    Route::get('/competitions/list-experiance',[UserController::class,'CompetitionAll'])->name('list-competition-all');
    Route::get('/competitions/form-experiance',[UserController::class,'CompetitionForm']);
    Route::post('/competitions/form-experiance',[UserController::class,'CompetitionStore']);
    Route::get('/competitions/form-experiance/{id}',[UserController::class,'CompetitionForm']);
    Route::put('/competitions/form-experiance/{id}',[UserController::class,'CompetitionUpdate']);
    Route::delete('/competitions/form-experiance/{id}',[UserController::class,'CompetitionDelete']);
    
    Route::post('/competitions/comment-experiance/{id}',[UserController::class,'CommentCompetitionStore']);

    Route::get('/tim/list-my-tim',[UserController::class,'ListTim'])->name('list-tim');
    Route::post('/tim/list-my-tim/feedback',[UserController::class,'TimFeedbackStore']);
    Route::put('/tim/list-my-tim/feedback/{id}',[UserController::class,'TimFeedbackUpdate']);
    Route::delete('/tim/list-my-tim/feedback/{id}',[UserController::class,'TimFeedbackDelete']);

    Route::get('/event/list-my-event',[UserController::class,'ListEvent'])->name('list-event');
    Route::post('/event/list-my-event/feedback',[UserController::class,'EventFeedbackStore']);
    Route::put('/event/list-my-event/feedback/{id}',[UserController::class,'EventFeedbackUpdate']);
    Route::delete('/event/list-my-event/feedback/{id}',[UserController::class,'EventFeedbackDelete']);
    
});
