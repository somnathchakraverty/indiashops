<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFcmTokensV1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('fcm_tokens', 'topic_added'))
        {
            Schema::table('fcm_tokens', function (Blueprint $table) {
                $table->tinyInteger('topic_added')->after('gcm_version')->default(1)->comment("1=Not Added,2=Added");
                $table->index('topic_added');
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
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropColumn(['topic_added']);
        });
    }
}
