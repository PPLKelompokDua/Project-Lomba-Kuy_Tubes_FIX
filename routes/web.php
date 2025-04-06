<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;

Route::get('/catalog', [CompetitionController::class, 'index'])->name('competitions.index');
