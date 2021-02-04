<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('precio',8 ,2);
            $table->integer('cantidad');
            $table->double('descuento',8 ,2)->default('0');
            //$table->foreignId('categoria_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->foreignId('categoria_producto_id')->constrained('categoria_productos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
