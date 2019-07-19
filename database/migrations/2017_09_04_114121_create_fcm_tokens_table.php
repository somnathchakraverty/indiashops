<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFcmTokensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('fcm_tokens') )
        {
            Schema::create('fcm_tokens', function (Blueprint $table) {
                $table->increments('id');
                $table->string('token');
                $table->enum('enabled', [0, 1])
                      ->comment("0=disabled,1=enabled")
                      ->default(1);
                $table->string('identifier',15);
                $table->string('source',20)->default('indiashopps');
                $table->integer('visit_count')->default(0);
                $table->index(['token', 'enabled','identifier'], 'fcm_token_index');
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
        Schema::drop('fcm_tokens');
    }

}
