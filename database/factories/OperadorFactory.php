<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Operador;
use Faker\Generator as Faker;

$factory->define(Operador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'apellido' => $faker->lastName,
        'ci' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'direccion' => $faker->address,

    ];
});
