<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_libros' => Libro::count(),
            'libros_prestados' => Prestamo::where('devuelto', false)->count(),
            'total_usuarios' => Usuario::count(),
            'top_libros' => Libro::select('titulo', DB::raw('COUNT(prestamos.id) as total'))
                ->leftJoin('prestamos', 'libros.id', '=', 'prestamos.libro_id')
                ->groupBy('libros.titulo')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
            'prestamos_mes' => Prestamo::whereMonth('created_at', now()->month)->count(),
        ], 200);
    }
}
