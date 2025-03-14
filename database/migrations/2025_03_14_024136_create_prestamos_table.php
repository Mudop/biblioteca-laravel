<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    public function up()
{
    Schema::table('prestamos', function (Blueprint $table) {
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade')->after('id');
    });
}

public function down()
{
    Schema::table('prestamos', function (Blueprint $table) {
        $table->dropForeign(['usuario_id']);
        $table->dropColumn('usuario_id');
    });
}

}
