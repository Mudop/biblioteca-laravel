<?php

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Libro;
use App\Models\Prestamo;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear usuarios
        Usuario::create([
            'nombre' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'rol' => 'admin'
        ]);
        ([
            'nombre' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'rol' => 'admin'
        ]);

        // Crear libros
        Libro::create([
            'titulo' => 'Cien Años de Soledad',
            'autor' => 'Gabriel García Márquez',
            'genero' => 'Realismo Mágico'
        ]);

        Libro::create([
            'titulo' => 'El Principito',
            'autor' => 'Antoine de Saint-Exupéry',
            'genero' => 'Fábula'
        ]);

        // Crear préstamo de prueba
        Prestamo::create([
            'usuario_id' => 1, // ID del usuario admin
            'libro_id' => 1, // ID del primer libro
            'devuelto' => false
        ]);
    }
}
