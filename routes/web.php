<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MaintenanceReportController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFileController;
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
    Route::post('projects/{project}/files', [ProjectFileController::class, 'store'])->name('projects.files.store');
    Route::get('project-files/{projectFile}/edit', [ProjectFileController::class, 'edit'])->name('project-files.edit');
    Route::put('project-files/{projectFile}', [ProjectFileController::class, 'update'])->name('project-files.update');
    Route::get('project-files/{projectFile}/download', [ProjectFileController::class, 'download'])->name('project-files.download');
    Route::delete('project-files/{projectFile}', [ProjectFileController::class, 'destroy'])->name('project-files.destroy');
    Route::resource('reports', MaintenanceReportController::class)->except(['destroy']);
});

require __DIR__.'/auth.php';
