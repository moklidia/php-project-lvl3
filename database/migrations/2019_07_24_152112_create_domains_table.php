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
			$table->integer('statusCode');
			$table->string('contentLength');
			$table->text('body');
			$table->string('h1');
			$table->string('keywords');
			$table->text('description');
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
