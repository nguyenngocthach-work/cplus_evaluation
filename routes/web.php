<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EvaluationsController;
use App\Http\Controllers\CriteriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/login', [DashboardController::class, 'loginPage'])
    ->middleware('guest')
    ->name('admin.login.screen');
Route::post('/login', [DashboardController::class, 'login'])->name('admin.login');
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login.screen');
})
->middleware('auth')
->name('admin.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'admin'])
        ->name('admin.screen');

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])
            ->name('projects.screen');

        Route::get('/create', [ProjectController::class, 'create'])
            ->name('projects.create.screen');

        Route::post('/', [ProjectController::class, 'store'])
            ->name('projects.store');
            
        Route::get('/export', [ProjectController::class, 'exportProjectList'])
            ->name('projects.export');

        Route::get('/{project}', [ProjectController::class, 'getById'])
            ->name('projects.getId');

        Route::get('/{project}/detail', [ProjectController::class, 'detail'])
            ->name('projects.detail');

        // Route::get('/{project}/evaluations', [ProjectController::class, 'getEvaluationsById'])
        //     ->name('projects.getEvaluationsId');

        Route::get('evaluations/{project}', [EvaluationsController::class, 'getEvaluationsById'])
            ->name('projects.evaluations.screen');

        Route::get('evaluations/{project}/export', [EvaluationsController::class, 'exportAll'])
            ->name('projects.evaluations.export');
            
        Route::get('evaluations/{project}/export-location/{industry}', [EvaluationsController::class, 'exportLocation'])
            ->name('projects.evaluations.exportLocation');

        Route::post('/evaluations', [ProjectController::class, 'scoreEvaluation'])
            ->name('projects.evaluationsScore');

        Route::get('/{project}/report', [ProjectController::class, 'getReportProjectById'])
            ->name('projects.reportById');

        Route::put('/{id}/update', [ProjectController::class,'update'])
            ->name('projects.update');

        Route::get('/{project}/export-csv', [ProjectController::class, 'exportProjectCsv'])
            ->name('projects.exportCsv');

        Route::put('/{id}/delete', [ProjectController::class, 'delete'])
            ->name('projects.delete');
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

        Route::get('/export', [ClientController::class, 'exportCLientList'])
            ->name('clients.export');
        
        Route::get('/{client}', [ClientController::class, 'getById'])
            ->name('clients.getId');

        Route::get('/{client}/detail', [ClientController::class, 'detail'])
            ->name('clients.detail');
            
        Route::put('/{id}/update', [ClientController::class,'update'])
            ->name('clients.update');
        
        Route::put('/{id}/delete', [ClientController::class, 'delete'])
            ->name('clients.delete');
    });

    Route::prefix('locations')->group(function () {
        Route::get('/', [LocationController::class, 'index'])
            ->name('locations.screen');

        Route::get('/create', [LocationController::class, 'create'])
            ->name('locations.create.screen');

        Route::post('/', [LocationController::class, 'store'])
            ->name('locations.store');
        
        Route::put('/{id}', [LocationController::class, 'update'])
            ->name('locations.update');
            
        Route::get('/search', [LocationController::class, 'search'])
            ->name('location.search');
            
        Route::put('/{id}/delete', [LocationController::class, 'delete'])
            ->name('locations.delete');
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
        
    });

    Route::prefix('criteria')->group(function (){
        Route::get('/', [CriteriaController::class, 'index'])
            ->name('criteria.screen');
        Route::get('/{criteria}', [CriteriaController::class, 'show'])
            ->name('criteria.detail');
        Route::post('/group', [CriteriaController::class, 'storeGroup'])
            ->name('criteria.group.store');
        Route::put('/group/{id}', [CriteriaController::class, 'updateGroup'])
            ->name('criteria.group.update');
        Route::post('/{groupId}/child', [CriteriaController::class, 'storeChild'])
            ->name('criteria.child.store');
        Route::put('/child/{id}', [CriteriaController::class, 'updateChild'])
            ->name('criteria.child.update');
    });
});