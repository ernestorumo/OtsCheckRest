<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Incidencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tienda_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->text('observacion',5000);
            $table->date('resolucion')->nullable(TRUE);
            $table->timestamps();
            
            $table->foreign('tienda_id')->references('id')->on('tiendas');
            $table->foreign('tipo_id')->references('id')->on('incidencia_tipos');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencias');
    }
}
