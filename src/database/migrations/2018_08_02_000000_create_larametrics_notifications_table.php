<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarametricsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larametrics_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->string('filter')->nullable();
            $table->text('meta')->nullable();
            $table->string('notify_by')->default('email');
            $table->timestamp('last_fired_at')->nullable();
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
        Schema::dropIfExists('larametrics_notifications');
    }
}
