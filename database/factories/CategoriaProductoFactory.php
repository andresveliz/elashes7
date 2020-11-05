<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categoria_producto;
use Faker\Generator as Faker;

$factory->define(Categoria_producto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'descripcion' => $faker->paragraph(),
    ];
});
