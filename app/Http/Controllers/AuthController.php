<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:usuarios',
        'password' => 'required|string|min:6',
        'rol' => 'in:admin,usuario' // Solo permite "admin" o "usuario"
    ]);

    $usuario = Usuario::create([
        'nombre' => $request->nombre,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol' => $request->rol ?? 'usuario' // Si no se especifica, será "usuario"
    ]);

    return response()->json([
        'message' => 'Usuario registrado correctamente',
        'user' => $usuario
    ], 201);
}


    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token
        ], 200);
    }

    // Logout de usuario
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ], 200);
    }
}
