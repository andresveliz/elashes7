<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha');
            $table->double('total',8 ,2);
            $table->integer('user_id');
            //$table->foreignId('operador_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('ventas', function (Blueprint $table) {
            $table->foreignId('operador_id')->constrained('operadores')->nullable()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
