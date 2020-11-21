<?php

use Faker\Generator as Faker;

$factory->define(App\Likes::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 50),
        'post_id' => rand(1, 50),
        'comment_id' => rand(1, 50),
		'like' => $faker->numberBetween($min = 0, $max = 1),		
    ];
});


