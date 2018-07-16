<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_ref', 10)->unique;
            $table->string('payment_type', 10);
            $table->unsignedInteger('payment_id');
            $table->ipAddress('ip_address', 40);
            $table->tinyInteger('opened');
            $table->unsignedInteger('order_status_id')->default(0);
            $table->unsignedInteger('shopper_id');
            $table->foreign('shopper_id')->references('id')->on('users');
            $table->unsignedInteger('mc_gross');
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
        Schema::dropIfExists('order');
    }
}
