<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProblemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('problems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('description');
			$table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

			$table->integer('academic_semester_id')->unsigned()->index();
			$table->foreign('academic_semester_id')->references('id')->on('academic_semesters');
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
		Schema::drop('problems');
	}

}
