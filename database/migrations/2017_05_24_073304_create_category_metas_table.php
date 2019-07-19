<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryMetasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('category_metas') )
		{
			Schema::create('category_metas', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('cat_id');
				$table->string('brand');
				$table->json('meta');
				$table->text('description')->nullable();
				$table->unique(['brand', 'cat_id']);
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
		Schema::drop('category_metas');
	}

}
