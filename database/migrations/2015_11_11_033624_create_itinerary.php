<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItinerary extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itinerary', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('day');
				$table->string('thumbnail');
				$table->string('title');
				$table->string('tinymce');
				$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('itinerary');
	}

}
