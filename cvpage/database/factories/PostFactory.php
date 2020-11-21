<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
	$title = $faker->sentence(4);
	return [
		'user_id' => rand(1, 20), //creamos 20 users
		'category_id' => rand(1, 20),
		'name' => $title,
		'slug' => str_slug($title),
		'description' => $faker->text(200),
		'file' => $faker->imageUrl($width = 750, $height = 300),
		'status' => $faker->randomElement(['DRAFT', 'PUBLISHED']),
	];
});
