<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_title', 500);
            $table->string('item_url')->unique();
            $table->string('item_url_ar')->unique();
            $table->longText('item_description')->nullable();
            $table->unsignedDecimal('item_price', 7, 2);
            $table->unsignedDecimal('was_price', 7, 2);
            $table->string('big_img')->nullable();
            $table->string('small_img')->nullable();
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->string('pdf_file')->nullable();
            $table->unsignedInteger('item_qty');
            $table->tinyInteger('discount'); //0 OR 1
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
        Schema::dropIfExists('items');
    }
}
