<?php

use Illuminate\Database\Seeder;
use App\Categoria_producto;

class CategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new Categoria_producto();
        $categoria->nombre = 'Pestañas';
        $categoria->descripcion = 'Productos E-lashes para pestañas';
        $categoria->save();

        $categoria = new Categoria_producto();
        $categoria->nombre = 'Yanbal';
        $categoria->descripcion = 'Productos Yanbal';
        $categoria->save();

        $categoria = new Categoria_producto();
        $categoria->nombre = 'Varios';
        $categoria->descripcion = 'Productos Varios';
        $categoria->save();


    }
}
