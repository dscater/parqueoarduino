<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("espacio_id");
            $table->date("fecha_ingreso");
            $table->time("hora_ingreso");
            $table->date("fecha_salida")->nullable();
            $table->time("hora_salida")->nullable();
            $table->integer("tiempo")->nullable();
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
        Schema::dropIfExists('ingreso_salidas');
    }
}
