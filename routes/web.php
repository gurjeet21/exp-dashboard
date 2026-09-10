<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MaintenanceReportController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class)->except(['destroy']);
    Route::resource('projects', ProjectController::class)->except(['destroy']);
    Route::resource('reports', MaintenanceReportController::class)->except(['destroy']);
});

require __DIR__.'/auth.php';
