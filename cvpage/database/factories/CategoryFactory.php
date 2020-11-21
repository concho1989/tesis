<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
	$title = $faker->sentence(4);
	return [
		'name' => $title,
		'slug' => str_slug($title), //helper de Laravel para convertir un string a slug
		'body' => $faker->text(500),
	];
});
