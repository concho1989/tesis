<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('interviews', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->string('time_experiencia')->nullable();
			$table->string('especialidad')->required();
			$table->string('pregunta_1')->required();
			$table->string('pregunta_2')->required();
			$table->string('pregunta_3')->required();
			$table->integer('porcentaje')->unsigned();
			$table->enum('status', ['NONE', 'STARTED', 'INTERMEDIATE', 'COMPLETED'])->default('NONE');
			$table->timestamps();

		});

	}

	/**
	 *
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('interviews');
	}
}
