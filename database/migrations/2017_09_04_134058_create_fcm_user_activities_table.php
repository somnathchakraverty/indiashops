<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFcmUserActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('fcm_user_activities') )
		{
			Schema::create('fcm_user_activities', function(Blueprint $table)
			{
				$table->integer('fcm_token_id');
				$table->mediumInteger('category_id');
				$table->index(['fcm_token_id']);
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fcm_user_activities');
	}

}
