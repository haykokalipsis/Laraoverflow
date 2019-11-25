<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    $users = User::all()->pluck('id')->all();

    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), '.'),
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => $faker->numberBetween(0, 10),
//        'answers_count' => $faker->numberBetween(0, 10), done with model created event in Answer model
//        'votes_count' => $faker->numberBetween(-10, 10), done with seeder
        'user_id' => $faker->randomElement($users),
    ];
});
