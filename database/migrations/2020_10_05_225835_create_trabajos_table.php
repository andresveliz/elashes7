<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('celular');
            $table->date('fecha');
            $table->time('hora',0);
            $table->string('detalle')->nullable();
            $table->string('codigo');
            $table->integer('user_id');
            //$table->foreignId('servicio_id');
            //$table->foreignId('operador_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('trabajos', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('operador_id')->constrained('operadores')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
