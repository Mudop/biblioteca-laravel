<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\DashboardController;


// 📌 Ruta de prueba para verificar que el backend funciona
Route::get('/test-cors', function () {
    return response()->json(['message' => 'CORS funciona correctamente'], 200);
});

// 📌 Manejo de CSRF con Sanctum (Debe estar fuera del middleware)
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// 📌 Rutas de Autenticación (Públicas)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// 📌 Rutas Protegidas con Autenticación (Usuarios autenticados con Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // 📌 Cerrar sesión
    Route::post('logout', [AuthController::class, 'logout']);

    // 📌 Ruta para el Dashboard (Muestra estadísticas de la biblioteca)
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'libros' => \App\Models\Libro::count(),
            'prestamos' => \App\Models\Prestamo::where('devuelto', false)->count(),
            'usuarios' => \App\Models\Usuario::count(),
        ]);
    });

    // 📌 Rutas SOLO PARA ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('libros', LibroController::class); // 📚 CRUD de libros
        Route::apiResource('usuarios', UsuarioController::class); // 🧑 CRUD de usuarios
    });

    Route::middleware('auth:sanctum')->get('/dashboard/stats', [DashboardController::class, 'stats']);


    // 📌 Rutas PARA ADMIN Y USUARIOS (Con permisos específicos)
    Route::get('prestamos', [PrestamoController::class, 'index']); // Usuario solo ve sus préstamos
    Route::post('prestamos', [PrestamoController::class, 'store']); // Crea su préstamo
    Route::put('prestamos/{id}/devolver', [PrestamoController::class, 'devolver']); // Solo dueños o admin pueden devolver libros

    // 📌 Eliminar préstamos (Solo admin)
    Route::delete('prestamos/{prestamo}', [PrestamoController::class, 'destroy'])->middleware('role:admin');
});
