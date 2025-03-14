<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    // 📌 Método para obtener todos los libros
    public function index()
    {
        return response()->json(Libro::all(), 200);
    }

    // 📌 Método para crear un nuevo libro
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'disponible' => 'boolean',
        ]);

        $libro = Libro::create($request->all());
        return response()->json($libro, 201);
    }

    // 📌 Método para mostrar un solo libro por ID
    public function show(Libro $libro)
    {
        return response()->json($libro, 200);
    }

    // 📌 Método para actualizar un libro
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'string|max:255',
            'autor' => 'string|max:255',
            'genero' => 'string|max:100',
            'disponible' => 'boolean',
        ]);

        $libro->update($request->all());
        return response()->json($libro, 200);
    }

    // 📌 Método para eliminar un libro
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return response()->json(['message' => 'Libro eliminado correctamente'], 200);
    }
}
