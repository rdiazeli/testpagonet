<?php

use App\User;
use App\Alumnos;
use App\Materias;
use App\Calificaciones;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'ap_paterno' => $faker->lastName,
        'ap_materno' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'activo' => $faker->randomElement([0, 1]),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Alumnos::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'ap_paterno' => $faker->lastName,
        'ap_materno' => $faker->lastName,
        'activo' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(Materias::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'activo' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(Calificaciones::class, function (Faker $faker) {
    return [
        'id_t_materia' => Materias::all()->random()->id_t_materia,
        'id_t_usuario' => Alumnos::all()->random()->id_t_usuario,
        'calificacion' => $faker->randomFloat(2, 6, 10),
        'fecha_registro' => $faker->dateTime,
    ];    
});
