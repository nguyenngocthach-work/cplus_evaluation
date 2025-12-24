<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Controller Routes
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Project logic
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('{id}/report', [ReportController::class, 'export'])->name('projects.report.export');
});

// Client logic (admin)
Route::prefix('admin/clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/create', [ClientController::class, 'create'])->name('admin.clients.create');
    Route::post('/', [ClientController::class, 'store'])->name('admin.clients.store');
});


/*
|--------------------------------------------------------------------------
| Screen Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::view('/', 'admin.admin_dashboard')->name('admin.dashboard');

    Route::view('/clients', 'manage_clients.manage_clients')
        ->name('admin.clients.screen');

    Route::view('/clients/create', 'manage_clients.client_create')
        ->name('admin.clients.create.screen');

    Route::view('/locations', 'manage_locations.manage_locations')
        ->name('admin.locations');

    Route::view('/projects', 'manage_projects.manage_projects')
        ->name('admin.projects');

    Route::view('/evaluations', 'manage_evaluations.manage_evaluations')
        ->name('admin.evaluations');

    Route::view('/evaluations-reports-export', 'evaluation_report_export.evaluation_report_export')
        ->name('admin.reports');
});