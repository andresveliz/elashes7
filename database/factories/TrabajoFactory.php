<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trabajo;
use Faker\Generator as Faker;

$factory->define(Trabajo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'apellido' => $faker->lastName,
        'celular' => $faker->phonNumber,
        'fecha' => $faker->date('Y-m-d'),
        'hora' => '12:00:00',
        'codigo' => 'ag-001',
        'user_id' => '1',
        'servicio_id' => '1',
        'operador_id' => '1'

    ];
});
