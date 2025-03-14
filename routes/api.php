<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

// 📌 Rutas de Autenticación (Públicas)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// 📌 Rutas Protegidas con Autenticación
Route::middleware('auth:sanctum')->group(function () {

    // Cerrar sesión
    Route::post('logout', [AuthController::class, 'logout']);

    // 📌 Rutas SOLO PARA ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('libros', LibroController::class);
        Route::apiResource('usuarios', UsuarioController::class);
    });

    // 📌 Rutas PARA ADMIN Y USUARIOS (Con permisos específicos)
    Route::middleware('role:usuario')->group(function () {
        Route::get('prestamos', [PrestamoController::class, 'index']); // Usuario solo ve sus préstamos
        Route::post('prestamos', [PrestamoController::class, 'store']); // Crea su préstamo
        Route::put('prestamos/{prestamo}', [PrestamoController::class, 'update']); // Solo puede modificar los suyos
        Route::put('prestamos/{id}/devolver', [PrestamoController::class, 'devolver']); // Solo dueños o admin pueden devolver libros
    });

    // 📌 Eliminar préstamos (Solo admin)
    Route::middleware('role:admin')->group(function () {
        Route::delete('prestamos/{prestamo}', [PrestamoController::class, 'destroy']);
    });
});
