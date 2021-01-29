<?php

use Illuminate\Database\Seeder;
use App\Categoria_servicio;

class CategoriaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Pestañas';
        $categoria->color = '#007bff';
        $categoria->save();

        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Depilaciones';
        $categoria->color = '#3c8dbc';
        $categoria->save();

        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Henna';
        $categoria->color = '#001f3f';
        $categoria->save();

        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Alisado';
        $categoria->color = '#6c757d';
        $categoria->save();

        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Maquillaje';
        $categoria->color = '#ffc107';
        $categoria->save();

        $categoria = new Categoria_servicio();
        $categoria->nombre = 'Uñas';
        $categoria->color = '#e83e8c';
        $categoria->save();
    }
}
