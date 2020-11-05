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
        factory(Categoria_servicio::class, 20)->create();
    }
}
