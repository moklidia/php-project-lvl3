<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('domains', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->integer('statusCode')->nullable();
			$table->string('contentLength')->nullable();
			$table->text('body')->nullable();
			$table->string('h1')->nullable();
			$table->string('keywords')->nullable();
			$table->text('description')->nullable();
			$table->string('state');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('domains');
	}
}
