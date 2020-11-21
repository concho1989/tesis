<?php

use Faker\Generator as Faker;

$factory->define(App\Speciality::class, function (Faker $faker) {
	$title = $faker->unique()->word(5);
	return [
		'name' => $title,
		'user_id' => rand(1, 20), //creamos 20 users
		'slug' => str_slug($title),
	];
});
