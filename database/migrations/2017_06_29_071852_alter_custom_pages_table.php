<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasColumn('custom_pages', 'featured'))
		{
			Schema::table('custom_pages', function (Blueprint $table) {
				$table->enum('featured',[0,1])->default(0);
				$table->index('featured');
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
		Schema::table('custom_pages', function (Blueprint $table) {
			$table->dropColumn(['featured']);
		});
	}

}
