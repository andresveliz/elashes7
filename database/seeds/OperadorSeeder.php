<?php

use Illuminate\Database\Seeder;
use App\Operador;

class OperadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operador = new Operador();
        $operador->nombre = 'Carola';
        $operador->apellido = 'Condori Morales';
        $operador->ci = '7455121';
        $operador->celular = '76150647';
        $operador->direccion = 'Canada Stronges, La plata';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Rocio';
        $operador->apellido = 'Pinto Mendoza';
        $operador->ci = '000001';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Katherine';
        $operador->apellido = 'SP';
        $operador->ci = '000002';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Megan';
        $operador->apellido = 'Cortez';
        $operador->ci = '000003';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Edith';
        $operador->apellido = 'Ortega Soruco';
        $operador->ci = '000004';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Magaly';
        $operador->apellido = 'Beza';
        $operador->ci = '000005';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();

        $operador = new Operador();
        $operador->nombre = 'Estefani';
        $operador->apellido = 'CR';
        $operador->ci = '000006';
        $operador->celular = '00000000';
        $operador->direccion = 'Direccion por confirmar';
        $operador->save();
    }
}
