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
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after:fecha_prestamo',
        ]);

        $prestamo = Prestamo::create([
            'usuario_id' => $request->user()->id, // Asigna el usuario autenticado
            'libro_id' => $request->libro_id,
            'fecha_prestamo' => $request->fecha_prestamo,
            'fecha_devolucion' => $request->fecha_devolucion,
            'devuelto' => false,
        ]);

        return response()->json([
            'message' => 'Préstamo registrado correctamente',
            'prestamo' => $prestamo
        ], 201);
    }

    // Registrar devolución de un libro (Solo el dueño o admin puede marcarlo como devuelto)
    public function devolver(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        // Verifica si el usuario es admin o si el préstamo le pertenece
        if ($request->user()->rol !== 'admin' && $prestamo->usuario_id !== $request->user()->id) {
            return response()->json(['error' => 'No tienes permisos para modificar este préstamo'], 403);
        }

        if ($prestamo->devuelto) {
            return response()->json(['error' => 'Este préstamo ya fue devuelto'], 400);
        }

        $prestamo->update([
            'fecha_devolucion' => now(),
            'devuelto' => true,
        ]);

        // Marcar el libro como disponible nuevamente
        $prestamo->libro->update(['disponible' => true]);

        return response()->json([
            'message' => 'Préstamo devuelto correctamente',
            'prestamo' => $prestamo
        ]);
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
