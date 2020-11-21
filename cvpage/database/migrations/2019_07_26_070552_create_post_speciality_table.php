<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSpecialityTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('post_speciality', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('post_id')->unsigned();
			$table->integer('speciality_id')->unsigned();
			$table->timestamps();

			$table->foreign('post_id')->references('id')->on('posts')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->foreign('speciality_id')->references('id')->on('specialities')
				->onDelete('cascade')
				->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('post_speciality');
	}
}
