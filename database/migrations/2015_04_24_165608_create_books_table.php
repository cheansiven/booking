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
		Schema::create('tour', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('code',20);
                        $table->string('name');
                        $table->integer('lenght_day');
                        $table->integer('lenght_night');
                        $table->integer('extension');
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
		Schema::drop('tour');
	}

}
