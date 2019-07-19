<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsDescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands_desc', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('category_id');
            $table->enum('upcoming', [0, 1]);
            $table->string('brand', 150);
            $table->text('text');
            $table->text('excerpt');
            $table->string('keys', 50);

            $table->index(['category_id', 'brand', 'upcoming']);
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
        Schema::dropIfExists('brands_desc');
    }
}
