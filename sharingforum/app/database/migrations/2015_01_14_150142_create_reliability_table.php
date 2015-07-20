<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReliabilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reliability', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

			$table->integer('solution_id')->unsigned()->index();
            $table->foreign('solution_id')->references('id')->on('solutions');

			$table->integer('reliability');
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
		Schema::drop('reliability');
	}

}
