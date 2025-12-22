<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\API\ClientController;

// be routers here
Route::get('/', [DashboardController::class, 'index']);

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('{id}', [ProjectController::class, 'show']);
    Route::get('{id}/report', [ReportController::class, 'export']);
});

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('admin.clients');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
});

// fe routers here
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.admin_dashboard')->name('admin.dashboard');
    Route::view('/clients', 'manage_clients.manage_clients')->name('admin.clients');
    Route::view('/locations', 'manage_locations.manage_locations');
    Route::view('/projects', 'manage_projects.manage_projects');
    Route::view('/clients-create', 'client_create.client_create')->name('admin.clients.create');
});