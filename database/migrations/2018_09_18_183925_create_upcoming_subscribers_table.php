<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpcomingSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upcoming_subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id', 50);
            $table->string('email',100);
            $table->tinyInteger('notified')->default(0)->comment("0=not notified, 1=notified");
            $table->index(['product_id', 'notified']);
            $table->dateTime('subscribed_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('notification_sent_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upcoming_subscribers');
    }
}
