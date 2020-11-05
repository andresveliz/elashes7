<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Servicio;
use Faker\Generator as Faker;

$factory->define(Servicio::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'precio' => '30.10',
        'cantidad' => '10',
        'descripcion' => $faker->sentence,
        'categoria_id' => '1'
    ];
});
