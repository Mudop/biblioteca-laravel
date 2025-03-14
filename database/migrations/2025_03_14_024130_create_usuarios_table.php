<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('email')->unique();
        $table->string('password'); // <-- Asegúrate de que esta línea esté aquí
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
