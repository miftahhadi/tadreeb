<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Exam;
use Faker\Generator as Faker;

$factory->define(Exam::class, function (Faker $faker) {
    return [
        'judul' => $faker->sentence(),
        'slug' => $faker->slug(),
        'deskripsi' => $faker->paragraph()
    ];
});
