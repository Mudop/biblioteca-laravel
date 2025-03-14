<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Extiende de Authenticatable
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable; // ✅ Necesario para autenticación con Sanctum

    protected $fillable = ['nombre', 'email', 'password', 'rol'];

    protected $hidden = ['password', 'remember_token'];
}
