<?php

use Illuminate\Database\Seeder;
use App\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicio = new Servicio();
        $servicio->nombre = 'Extension de Pestañas';
        $servicio->precio = '90';
        $servicio->descripcion = 'Extensiones basicas';
        $servicio->comision = '30';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '1';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Extension de Pestañas Fibra Natural';
        $servicio->precio = '120';
        $servicio->descripcion = 'Tecnica fibra natural';
        $servicio->comision = '30';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '1';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Extension de Pestañas Fibra Semi Tupido';
        $servicio->precio = '150';
        $servicio->descripcion = 'Tecnica fibra semi tupido';
        $servicio->comision = '30';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '1';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Extension de Pestañas Curva Extrema';
        $servicio->precio = '100';
        $servicio->descripcion = 'Tecnica curva extrema';
        $servicio->comision = '30';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '1';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Lifting de Pestañas Superiores';
        $servicio->precio = '100';
        $servicio->descripcion = 'Lifting';
        $servicio->comision = '30';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '1';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Depilacion de Cejas con Hilo';
        $servicio->precio = '50';
        $servicio->descripcion = 'Cejas';
        $servicio->comision = '12';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '11';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Depilacion de Bozo con Hilo';
        $servicio->precio = '30';
        $servicio->descripcion = 'Bozo';
        $servicio->comision = '10';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '11';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Depilacion de Cejas con Cera';
        $servicio->precio = '25';
        $servicio->descripcion = 'Cejas';
        $servicio->comision = '12';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '11';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Depilacion de Rostro Completo';
        $servicio->precio = '85';
        $servicio->descripcion = 'Rostro completo con cera';
        $servicio->comision = '40';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '11';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Pintado de cejas con Henna';
        $servicio->precio = '50';
        $servicio->descripcion = 'Cejas';
        $servicio->comision = '17';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '21';
        $servicio->save();

        $servicio = new Servicio();
        $servicio->nombre = 'Alisado de Cejas';
        $servicio->precio = '50';
        $servicio->descripcion = 'Cejas';
        $servicio->comision = '12';
        $servicio->descuento = '0';
        $servicio->categoria_servicio_id = '31';
        $servicio->save();


    }
}
