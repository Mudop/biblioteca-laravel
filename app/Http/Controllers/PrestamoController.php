<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    // Obtener todos los préstamos
    public function index()
    {
        return response()->json(Prestamo::with(['libro', 'usuario'])->get());
    }

    // Registrar un préstamo
    public function store(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha_prestamo' => 'required|date',
        ]);

        // Verificar si el libro está disponible
        $libro = Libro::findOrFail($request->libro_id);
        if (!$libro->disponible) {
            return response()->json(['error' => 'Este libro no está disponible'], 400);
        }

        // Marcar el libro como no disponible
        $libro->update(['disponible' => false]);

        // Crear el préstamo
        $prestamo = Prestamo::create($request->all());

        return response()->json($prestamo, 201);
    }

    // Registrar devolución de un libro
    public function devolver($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->fecha_devolucion !== null) {
            return response()->json(['error' => 'Este préstamo ya fue devuelto'], 400);
        }

        $prestamo->update(['fecha_devolucion' => now()]);

        // Marcar el libro como disponible nuevamente
        $prestamo->libro->update(['disponible' => true]);

        return response()->json($prestamo);
    }
}
