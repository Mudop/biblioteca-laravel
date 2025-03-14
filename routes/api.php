<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

// CRUD de libros
Route::apiResource('libros', LibroController::class);

// CRUD de usuarios
Route::apiResource('usuarios', UsuarioController::class);

// Gestión de préstamos
Route::get('prestamos', [PrestamoController::class, 'index']);
Route::post('prestamos', [PrestamoController::class, 'store']);
Route::put('prestamos/{id}/devolver', [PrestamoController::class, 'devolver']);
