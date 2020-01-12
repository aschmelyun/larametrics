<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarametricsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larametrics_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->text('uri');
            $table->string('ip')->nullable();
            $table->text('headers')->nullable();
            $table->float('start_time', 16, 4)->nullable();
            $table->float('end_time', 16, 4)->nullable();
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
        Schema::dropIfExists('larametrics_requests');
    }
}
