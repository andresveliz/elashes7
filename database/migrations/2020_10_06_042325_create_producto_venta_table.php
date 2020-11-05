<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_venta', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->unsigned();
            $table->double('sub_total')->default(0);
            $table->timestamps();
        });
        Schema::table('producto_venta', function (Blueprint $table) {
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_venta');
    }
}
