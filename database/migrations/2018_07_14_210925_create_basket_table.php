<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_title');
            $table->unsignedDecimal('price', 7, 2);
            $table->unsignedInteger('item_qty');
            $table->string('item_color')->nullable();
            $table->string('item_size')->nullable();
            $table->unsignedInteger('shopper_id');
            $table->string('ip_address', 40);
            $table->timestamps();

            $table->foreign('shopper_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket');
    }
}
