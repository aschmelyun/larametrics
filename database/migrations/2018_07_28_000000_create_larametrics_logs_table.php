<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarametricsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larametrics_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level');
            $table->text('message');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->text('trace');
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
        Schema::dropIfExists('larametrics_logs');
    }
}
