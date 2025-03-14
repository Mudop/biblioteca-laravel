<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return response()->json(['message' => 'Página de Login no disponible en esta API'], 404);
})->name('login');
