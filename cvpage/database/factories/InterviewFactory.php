<?php

use Faker\Generator as Faker;

$factory->define(App\Interview::class, function (Faker $faker) {
	$title = $faker->sentence(4);
	return [
		'user_id' => rand(1, 20), //creamos 20 users
		'company_id' => rand(1, 20),
		'porcentaje' => $faker->numberBetween($min = 0, $max = 5),
		'especialidad' => str_slug($title),
		'pregunta_1' => $faker->text(40),
		'pregunta_2' => $faker->text(40),
		'pregunta_3' => $faker->text(40),
		'porcentaje' => $faker->numberBetween($min = 0, $max = 100),
		'status' => $faker->randomElement(['NONE', 'STARTED', 'INTERMEDIATE', 'COMPLETED']),

	];
});
