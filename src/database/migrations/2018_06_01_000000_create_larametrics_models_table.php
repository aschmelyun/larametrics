<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarametricsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larametrics_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->integer('model_id');
            $table->string('method');
            $table->text('original')->nullable();
            $table->text('changes')->nullable();
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
        Schema::dropIfExists('larametrics_models');
    }
}
