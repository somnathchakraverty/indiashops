<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('product_images') )
		{
			Schema::create('product_images', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('product_id');
				$table->text('image_url');
				$table->index('product_id');
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
		Schema::drop('product_images');
	}

}
