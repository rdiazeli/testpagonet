<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_calificaciones', function (Blueprint $table) {
            $table->increments('id_t_calificacion');
            $table->unsignedInteger('id_t_materia');
            $table->unsignedInteger('id_t_usuario');
            $table->decimal('calificacion', 10, 2);
            $table->date('fecha_registro');

            $table->foreign('id_t_materia')->references('id_t_materia')->on('t_materias');
            $table->foreign('id_t_usuario')->references('id_t_usuario')->on('t_alumnos');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_calificaciones');
    }
}
