<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'precio' => '30.10',
        'cantidad' => '10',
        'categoria_id' => '1',

    ];
});
