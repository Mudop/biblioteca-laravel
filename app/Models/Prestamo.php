<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'libro_id', 'fecha_prestamo', 'fecha_devolucion', 'devuelto'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
