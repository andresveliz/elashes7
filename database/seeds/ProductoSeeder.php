<?php

use Illuminate\Database\Seeder;
use App\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producto = new Producto();
        $producto->nombre = 'Rimel para Pestañas';
        $producto->precio = '120';
        $producto->cantidad = '15';
        $producto->descuento = '0';
        $producto->categoria_producto_id = '1';
        $producto->save();

        $producto = new Producto();
        $producto->nombre = 'Vitamina para Pestañas';
        $producto->precio = '145';
        $producto->cantidad = '10';
        $producto->descuento = '0';
        $producto->categoria_producto_id = '1';
        $producto->save();

        $producto = new Producto();
        $producto->nombre = 'Peine para Pestañas';
        $producto->precio = '2';
        $producto->cantidad = '30';
        $producto->descuento = '0';
        $producto->categoria_producto_id = '1';
        $producto->save();

        $producto = new Producto();
        $producto->nombre = 'Perfume Black';
        $producto->precio = '150';
        $producto->cantidad = '2';
        $producto->descuento = '0';
        $producto->categoria_producto_id = '2';
        $producto->save();

        $producto = new Producto();
        $producto->nombre = 'Maquillaje Sermat';
        $producto->precio = '150';
        $producto->cantidad = '2';
        $producto->descuento = '0';
        $producto->categoria_producto_id = '3';
        $producto->save();
    }
}
