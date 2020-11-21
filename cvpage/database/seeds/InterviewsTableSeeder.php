<?php

use Illuminate\Database\Seeder;

class InterviewsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(App\Interview::class, 20)->create();
	}
}
