<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string("store_title", 500);
            $table->longText('description');
            $table->string('phone_number', 40);
            $table->string('email', 120);
            $table->string('address1', 60);
            $table->string('address2', 60)->nullable();
            $table->string('country', 60);
            $table->string('town', 60);
            $table->integer('postal_code');
            $table->string('picture');
            $table->enum('network', ['facebook', 'twitter', 'instagram', 'youtube'])->nullable();
            $table->deciaml('latitude', 10, 8);
            $table->deciaml('longitude', 11, 10);
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
        Schema::dropIfExists('store_information');
    }
}
