<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    // Obtener todos los préstamos (Admin ve todos, usuario solo los suyos)
    public function index(Request $request)
    {
        if ($request->user()->rol === 'admin') {
            $prestamos = Prestamo::all();
        } else {
            $prestamos = Prestamo::where('usuario_id', $request->user()->id)->get();
        }

        return response()->json($prestamos);
    }

    // Registrar un préstamo (Solo usuarios autenticados)
    public function store(Request $request)
{
    $request->validate([
        'libro_id' => 'required|exists:libros,id',
    ]);

    $prestamo = Prestamo::create([
        'usuario_id' => auth()->id(),
        'libro_id' => $request->libro_id,
        'fecha_prestamo' => now(), // 📌 Se asigna la fecha actual automáticamente
        'devuelto' => false,
    ]);

    return response()->json($prestamo, 201);
}

    

    // Registrar devolución de un libro (Solo el dueño o admin puede marcarlo como devuelto)
    public function devolver($id)
{
    $prestamo = Prestamo::find($id);

    if (!$prestamo) {
        return response()->json(['error' => 'Préstamo no encontrado'], 404);
    }

    if ($prestamo->devuelto) {
        return response()->json(['error' => 'El libro ya fue devuelto'], 400);
    }

    $prestamo->update(['devuelto' => true]);

    return response()->json(['message' => 'Libro devuelto correctamente']);
}


    // Actualizar un préstamo (Solo el dueño o admin puede modificarlo)
    public function update(Request $request, Prestamo $prestamo)
    {
        if ($request->user()->rol !== 'admin' && $prestamo->usuario_id !== $request->user()->id) {
            return response()->json(['error' => 'No tienes permisos para modificar este préstamo'], 403);
        }

        $request->validate([
            'fecha_devolucion' => 'nullable|date|after:fecha_prestamo',
            'devuelto' => 'boolean',
        ]);

        $prestamo->update($request->all());

        return response()->json([
            'message' => 'Préstamo actualizado correctamente',
            'prestamo' => $prestamo
        ]);
    }

    // Eliminar un préstamo (Solo admin puede eliminarlo)
    public function destroy(Request $request, Prestamo $prestamo)
    {
        if ($request->user()->rol !== 'admin') {
            return response()->json(['error' => 'No tienes permisos para eliminar este préstamo'], 403);
        }

        $prestamo->delete();

        return response()->json(['message' => 'Préstamo eliminado correctamente']);
    }
}
