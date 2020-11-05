<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categoria_servicio;
use Faker\Generator as Faker;

$factory->define(Categoria_servicio::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence(),
        'color' => $faker->color()
    ];
});
