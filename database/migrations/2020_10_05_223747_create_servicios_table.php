<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('precio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->double('comision', 8, 2);
            $table->double('descuento', 8, 2)->default('0');
            $table->boolean('extra')->default(false);
            //$table->foreignId('categoria_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('servicios', function (Blueprint $table) {
            $table->foreignId('categoria_servicio_id')->constrained('categoria_servicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
