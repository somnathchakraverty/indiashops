<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFcmTokensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('fcm_tokens', 'gcm_version'))
        {
            Schema::table('fcm_tokens', function (Blueprint $table) {
                $table->enum('gcm_version', [1, 2])
                      ->after('source')
                      ->default(1)
                      ->comment("1=Firebase,2=GCM Olds");
                $table->index('gcm_version');
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
            $table->dropColumn(['gcm_version']);
        });
    }

}
