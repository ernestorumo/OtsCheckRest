<?php

use App\Incidencia;
use App\IncidenciaTipo;
use App\Tienda;
use App\User;
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
    static $password;
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?:$password = bcrypt('secret'), // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(Tienda::class, function (Faker $faker) {
   
    return [
        'id' => $faker->unique()->numberBetween(100, 199),
    ];
});

$factory->define(IncidenciaTipo::class, function (Faker $faker) {
   
    return [
        'nombre' => $faker->unique()->randomElement(['aire acondicionado','electricidad','persiana','conexion']) 
    ];
});

$factory->define(Incidencia::class, function (Faker $faker) {
   
    return [
        'tienda_id' => Tienda::all()->random()->id,
        'tipo_id' => IncidenciaTipo::all()->random()->id,
        'observacion' => $faker->paragraph(3),
        'resolucion' => $faker->randomElement([$faker->dateTime(now()),null]),
    ];
});