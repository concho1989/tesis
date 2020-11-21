<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	/*
		attach() se usa para relacionar un post con una etiqueta
	*/
	public function run() {
		factory(App\Post::class, 20)->create()->each(function (App\Post $post) {
			$post->tags()->attach([
				rand(1, 5),
				rand(6, 14),
				rand(15, 20),
			]);
		});
	}
}