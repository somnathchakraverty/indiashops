<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsMetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('deals_meta') )
		{
			Schema::create('deals_meta', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('vendor_name',100);
				$table->text('meta_data');
				$table->text('description');
				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

				$table->index(['vendor_name']);
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
		Schema::drop('deals_meta');
	}

}
