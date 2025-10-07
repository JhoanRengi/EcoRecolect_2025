<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CollectorCompanyController;
use App\Http\Controllers\Admin\CollectionScheduleController;
use App\Http\Controllers\Admin\DashboardAdmin;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\PickupController;

// Públicas
Route::get('/',           [HomeController::class, 'landing'])->name('home');
Route::get('/nosotros',   [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/planes',     [HomeController::class, 'planes'])->name('planes');
Route::get('/contacto',   [HomeController::class, 'contacto'])->name('contacto');
Route::post('/contacto',  [ContactoController::class, 'store'])->name('contacto.store');

// Usuario
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::middleware(['auth','verified', EnsureUserIsAdmin::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');
        Route::post('/companies', [CollectorCompanyController::class, 'store'])->name('companies.store');
        Route::delete('/companies/{company}', [CollectorCompanyController::class, 'destroy'])->name('companies.destroy');

        Route::post('/collections', [CollectionScheduleController::class, 'store'])->name('collections.store');
        Route::patch('/collections/{schedule}', [CollectionScheduleController::class, 'update'])->name('collections.update');
        Route::delete('/collections/{schedule}', [CollectionScheduleController::class, 'destroy'])->name('collections.destroy');

        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::post('/reports/collections', [ReportController::class, 'collections'])->name('reports.collections');
        Route::post('/reports/by-user', [ReportController::class, 'byUser'])->name('reports.by-user');
        Route::post('/reports/by-locality', [ReportController::class, 'byLocality'])->name('reports.by-locality');
        Route::post('/reports/by-company', [ReportController::class, 'byCompany'])->name('reports.by-company');
        // Route::get('/ping', fn() => 'ADMIN OK')->name('ping');
    });

Route::middleware(['auth','verified'])->group(function () {

    // DASHBOARD DE USUARIO
    Route::get('/panel', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    

    // PICKUPS (solicitar recolección)
    Route::get('/recoleccion/solicitar', [PickupController::class, 'create'])
        ->name('user.pickups.create');
    Route::post('/recoleccion', [PickupController::class, 'store'])
        ->name('user.pickups.store');

    // REPORTES
    Route::post('/reportes/recolecciones.csv', [UserDashboardController::class, 'downloadCsv'])
        ->name('user.reports.download');

    // RECOMPENSAS
    Route::get('/recompensas/catalogo', [UserDashboardController::class, 'catalog'])
        ->name('user.rewards.catalog');
    Route::get('/recompensas/canjear', [UserDashboardController::class, 'redeem'])
        ->name('user.rewards.redeem');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::redirect('/dashboard', '/panel')->name('dashboard'); // compat
    Route::redirect('/home', '/panel');

});



// Rutas de login/registro/reset
require __DIR__.'/auth.php';
