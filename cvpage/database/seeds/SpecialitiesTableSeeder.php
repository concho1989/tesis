<?php

use Illuminate\Database\Seeder;

class SpecialitiesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(App\Speciality::class, 20)->create();
	}
}
