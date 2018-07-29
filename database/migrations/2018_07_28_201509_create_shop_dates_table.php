<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->time('sat_from');
            $table->time('sat_to');
            $table->tinyInteger('sat_status');

            $table->time('sun_from');
            $table->time('sun_to');
            $table->tinyInteger('sun_status');

            $table->time('mon_from');
            $table->time('mon_to');
            $table->tinyInteger('mon_status');

            $table->time('tue_from');
            $table->time('tue_to');
            $table->tinyInteger('tue_status');

            $table->time('wed_from');
            $table->time('wed_to');
            $table->tinyInteger('wed_status');

            $table->time('thu_from');
            $table->time('thu_to');
            $table->tinyInteger('thu_status');

            $table->time('fri_from');
            $table->time('fri_to');
            $table->tinyInteger('fri_status');

            $table->unsignedInteger('parent_id');

            $table->foreign('parent_id')->references('id')->on('store_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_dates');
    }
}
