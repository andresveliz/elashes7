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
        factory(App\Categoria_producto::class, 10)->create();
    }
}
