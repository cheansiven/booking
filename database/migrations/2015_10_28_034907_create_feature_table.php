<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feature', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tour_id');
			$table->foreign('tour_id')
						->references('id')->on('tour')
						->onDelete('cascade');
			$table->string('text');
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
			Schema::drop('feature');
	}
}
