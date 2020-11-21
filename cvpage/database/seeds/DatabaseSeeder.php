<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(PermissionsTableSeeder::class);
		$this->call(RoleTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(CompaniesTableSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(SpecialitiesTableSeeder::class);
		$this->call(PostsTableSeeder::class);
		$this->call(InterviewsTableSeeder::class);
	}
}
