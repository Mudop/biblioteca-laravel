<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        return response()->json(Usuario::all());
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
        ]);

        $usuario = Usuario::create($request->all());

        return response()->json($usuario, 201);
    }

    // Mostrar un usuario específico
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    // Actualizar un usuario
    public function update(Request $request, Usuario $usuario)
    {
        $usuario->update($request->all());

        return response()->json($usuario);
    }

    // Eliminar un usuario
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
