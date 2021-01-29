<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategoriaProductoSeeder::class);
        $this->call(CategoriaServicioSeeder::class);
        $this->call(OperadorSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(ServicioSeeder::class);
    }
}
