<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollectionController;

// Ruta de la página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showStep1'])->name('register');
Route::post('/register/step-2', [AuthController::class, 'processStep1'])->name('register.step2');
Route::get('/register/step-2', [AuthController::class, 'showStep2'])->name('register.step2.show');
Route::post('/register/step-3', [AuthController::class, 'processStep2'])->name('register.step3');
Route::get('/register/step-3', [AuthController::class, 'showStep3'])->name('register.step3.show');
Route::post('/register/complete', [AuthController::class, 'processStep3'])->name('register.complete');

Route::middleware(['auth'])->group(function () {
    // Muestra el dashboard del usuario
    Route::get('/dashboard', [CollectionController::class, 'dashboard'])->name('dashboard');
Route::post('/collections/store', [CollectionController::class, 'store'])->name('collections.store');

    // Rutas del Perfil
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');

     // Rutas para la programación de recolecciones
    Route::get('/programar-recoleccion', [CollectionController::class, 'create'])->name('collections.create');
    Route::post('/programar-recoleccion', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/export/pdf', [CollectionController::class, 'exportPdf'])->name('collections.export.pdf');
Route::get('/collections/export/excel', [CollectionController::class, 'exportExcel'])->name('collections.export.excel');
Route::post('/collections/reprogram/{id}', [CollectionController::class, 'reprogram'])
    ->name('collections.reprogram');
});
