<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'judul' => $faker->sentence(),
        'slug' => $faker->slug(),
        'deskripsi' => $faker->paragraph()
    ];
});
