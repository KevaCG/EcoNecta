<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta para la página principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta protegida (requiere que el usuario esté autenticado)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return "¡Bienvenido al panel de control!";
    })->name('dashboard');
});
