<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venta;
use Faker\Generator as Faker;

$factory->define(Venta::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'apellido' => $faker->lastName,
        'fecha' => $faker->date('Y-m-d'),
        'hora' => '12:00:00',
        'user_id' => '1',
        
    ];
});
