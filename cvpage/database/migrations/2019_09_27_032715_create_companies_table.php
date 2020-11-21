<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration {
	/**
	 * Run the migrations 2226116272
	 * https://www.youtube.com/watch?v=vyLpqpBiMYw
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('companies', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('interview_id')->unsigned()->nullable();
			$table->string('name', 128)->required(); // Laravel 5.5
			$table->string('time_expe')->nullable();
			$table->string('address')->nullable();
			$table->string('file', 128)->nullable();
			$table->mediumText('descripcion')->nullable();
			$table->string('cellphone')->nullable();
			$table->string('email', 128)->unique();
			$table->string('password')->required();
			$table->string('confirpassword')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('companies');
	}
}
