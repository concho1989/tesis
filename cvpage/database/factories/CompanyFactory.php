<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
	$title = $faker->sentence(4);
	return [
		'user_id' => rand(1, 20), //creamos 20 users
		'interview_id' => rand(1, 20),
		'name' => $title,
		'time_expe' => $faker->numberBetween($min = 0, $max = 5),
		'address' => $faker->address,
		'file' => $faker->imageUrl($width = 35, $height = 35),
		'descripcion' => $faker->text(200),
		'cellphone' => $faker->e164PhoneNumber,
		'email' => $faker->unique()->email,
		'password' => bcrypt('secret')

	];
});
