<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_alumnos', function (Blueprint $table) {
            $table->increments('id_t_usuario');
            $table->string('nombre', 80);
            $table->string('ap_paterno', 80);
            $table->string('ap_materno', 80);
            $table->integer('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_alumnos');
    }
}
