<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFcmTokensV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->string('browser', '20')->after('visit_count')->nullable()->comment("User Browser..");
            $table->string('sw_version', '10')
                  ->after('browser')
                  ->default('v1')
                  ->comment("User Service Worker file version");
            $table->index('sw_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropColumn(['sw_version', 'browser']);
        });
    }
}
