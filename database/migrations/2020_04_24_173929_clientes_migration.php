<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('nombre');
            $table->string('nif');
            $table->string('direccion');
            $table->string('correo');
            $table->string('fechaInscripcion');
            $table->enum('tarifa',['medio_mes', 'mes', 'trimestre', 'semestre']);
            $table->string('contrasena');

            // Para que también cree automáticamente los campos timestamps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
