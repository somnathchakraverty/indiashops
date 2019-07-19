<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccasionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('occasions') )
		{
			Schema::create('occasions', function (Blueprint $table) {
				$table->increments('id');
				$table->string('product_id',20);
				$table->string('name');
				$table->string('image_url');
				$table->smallInteger('price')->default('0');
				$table->smallInteger('salesprice')->default('0');
				$table->text('product_url');
				$table->string('category',50);
				$table->string('type',50);
				$table->timestamps();

				$table->index(['product_id','type']);
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
		Schema::drop('occasions');
	}

}
