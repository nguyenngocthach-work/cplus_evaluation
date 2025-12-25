<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EvaluationsController;

Route::get('/', [DashboardController::class, 'admin'])->name('admin.screen');


Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])
            ->name('projects.screen');

        Route::get('/create', [ProjectController::class, 'create'])
            ->name('projects.create.screen');

        Route::post('/', [ProjectController::class, 'store'])
            ->name('projects.store');
    });

Route::prefix('/clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])
        ->name('clients.screen');

    Route::get('/create', [ClientController::class, 'create'])
        ->name('clients.create.screen');

    Route::post('/', [ClientController::class, 'store'])
        ->name('clients.store');

    Route::get('/search', [ClientController::class, 'search'])
        ->name('clients.search');
});

Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'index'])
        ->name('locations.screen');

    Route::get('/create', [LocationController::class, 'create'])
        ->name('locations.create.screen');

    Route::post('/', [LocationController::class, 'store'])
        ->name('locations.store');
});
    
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportsController::class, 'index'])
        ->name('reports.screen');

    Route::get('/create', [ReportsController::class, 'create'])
        ->name('reports.create.screen');

    Route::post('/', [ReportsController::class, 'store'])
        ->name('reports.store');
});

Route::prefix('evaluations')->group(function () {
        Route::get('/', [EvaluationsController::class, 'index'])
            ->name('evaluations.screen');

        Route::get('/create', [EvaluationsController::class, 'create'])
            ->name('evaluations.create.screen');

        Route::post('/', [EvaluationsController::class, 'store'])
            ->name('evaluations.store');
});