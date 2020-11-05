<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reserva;
use Faker\Generator as Faker;

$factory->define(Reserva::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'apellido' => $faker->lastName,
        'celular' => $faker->phonNumber,
        'fecha' => $faker->date('Y-m-d'),
        'hora' => '12:00:00',
        'user_id' => '1'

    ];
});
