<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'schedules', function( $table ) {
			$table->dropForeign('schedules_user_id_foreign');
			$table->dropColumn('user_id');
	    	
			$table->integer('ta1_id')->unsigned()->nullable();
			$table->foreign('ta1_id')->references('id')->on('users')->onDelete('cascade');
			
			$table->integer('ta2_id')->unsigned()->nullable();
			$table->foreign('ta2_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'schedules', function( $table ) {
			$table->dropForeign('schedules_ta1_id_foreign');
			$table->dropColumn('ta1_id');
			$table->dropForeign('schedules_ta2_id_foreign');
			$table->dropColumn('ta2_id');

			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

}
