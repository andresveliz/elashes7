<?php

use Illuminate\Database\Seeder;
use App\Trabajo;

class TrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trabajo = new Trabajo();
        $trabajo->nombre = 'Primer';
        $trabajo->apellido = 'Cliente';
        $trabajo->celular = '0000000';
        $trabajo->fecha = '2021-02-04';
        $trabajo->hora = '12:00:00';
        $trabajo->codigo = 'Feb0000';
        $trabajo->descuento = '90';
        $trabajo->servicio_id = '1';
        $trabajo->operador_id = '1';
        $trabajo->user_id = '1';
        $trabajo->save();
    }
}
