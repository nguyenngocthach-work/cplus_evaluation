<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;

// be routers here
Route::get('/', [DashboardController::class, 'index']);

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('{id}', [ProjectController::class, 'show']);
    Route::get('{id}/report', [ReportController::class, 'export']);
});

// fe routers here
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.admin_dashboard');
    Route::view('/clients', 'manage_clients.manage_clients');
    Route::view('/locations', 'manage_locations.manage_locations');
    Route::view('/projects', 'manage_projects.manage_projects');
});