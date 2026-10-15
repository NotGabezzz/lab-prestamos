<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// solo para quien NO ha iniciado sesión
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    // máximo 5 intentos por minuto, frena adivinar contraseñas
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// todo lo de aquí dentro exige sesión iniciada
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/panel', PanelController::class)->name('panel');

    // solo estudiantes
    Route::middleware('rol:estudiante')->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/equipos', [EstudianteController::class, 'equipos'])->name('equipos');
        Route::get('/mi-actividad', [EstudianteController::class, 'actividad'])->name('actividad');
        Route::post('/equipos/{equipo}/solicitar', [EstudianteController::class, 'solicitar'])->name('solicitar');
    });

    // solo el encargado
    Route::middleware('rol:encargado')->prefix('encargado')->name('encargado.')->group(function () {
        Route::resource('equipos', EquipoController::class)->except('show');

        Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
        Route::post('/equipos/{equipo}/prestar', [PrestamoController::class, 'store'])->name('prestamos.store');
        Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');

        Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::post('/solicitudes/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
        Route::post('/solicitudes/{solicitud}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
    });
});