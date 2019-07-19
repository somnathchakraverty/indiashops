<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_listing', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('category_id');
            $table->string('title', 255);
            $table->string('keywords', 300);
            $table->text('short_description');
            $table->text('description');
            $table->string('h1');
            $table->string('table_heading');
            $table->text('content');
            $table->index('category_id');
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
        Schema::dropIfExists('brand_listing');
    }
}
