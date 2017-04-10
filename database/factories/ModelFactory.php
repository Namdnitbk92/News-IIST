<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'api_token' => str_random(60),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'role_id' => $faker->unique()->randomNumber,
        'description' => 'this is role test...',
    ];
});

$factory->define(App\Places::class, function (Faker\Generator $faker) {
    return [
        'lat' => $faker->randomFloat(2, 0, 200),
        'lng' => $faker->randomFloat(2, 0, 200),
        'name' => 'place test',
        'type' => 'city',
    ];
});

$factory->define(App\News::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->address,
        'sub_title' => $faker->address,
        'audio_path' => 'https:/zing.vn',
        'place_id' => function () {
            return factory(App\Places::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'status_id' => 1,
    ];
});

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Ha Noi',
    ];
});

$factory->define(App\County::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['Thanh xuan', 'Dong Da', 'Long bien']).' '.$faker->randomDigit(),
        'city_id' => 1,
    ];
});

$factory->define(App\Guild::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['Thinh Quang', 'Lang Ha', 'Trung Tu']).' '.$faker->randomDigit(),
        'county_id' => function () {
            return factory(App\County::class)->create()->id;
        }
    ];
});
