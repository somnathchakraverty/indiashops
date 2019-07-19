<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomPagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('custom_pages') )
        {
            Schema::create('custom_pages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug');
                $table->smallInteger('category_id');
                $table->json('meta_data')->nullable();
                $table->json('filters')->nullable();
                $table->index(['slug', 'category_id']);
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
        Schema::drop('custom_pages');
    }

}
