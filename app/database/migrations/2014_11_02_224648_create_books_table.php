<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function($table) {

			//set up your primary key and make it auto increment
			$table->increments('id');
			$table->timestamps('author');

			$table->string('author');
			$table->string('title');
			$table->integer('published');
			$table->string('cover');
			$table->string('purchase_link');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}

}
