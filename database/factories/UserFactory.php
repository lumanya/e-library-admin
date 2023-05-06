<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
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
        'username' => $faker->userName,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'contact_number' => $faker->numberBetween(100000,99999999999999),
        'email_verified_at' => now(),
        'password' => bcrypt('123456'),
        'remember_token' => Str::random(10),
        'activation_token' => Str::random(15),
        'user_type' => 'user',
        'registration_id' => '',
        'device_id' => '',
        'image' => $faker->imageUrl(300,300,'people'),
        'status' => 'active',
        'created_at'=> $faker->date($format = 'Y-m-d', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
