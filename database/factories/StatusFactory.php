<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'content'    => $faker->text(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
