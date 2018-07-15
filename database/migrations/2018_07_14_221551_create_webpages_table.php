<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_title');
            $table->string('page_url');
            $table->string('page_keywords')->nullable();
            $table->text('page_description')->nullable();
            $table->string('headline')->nullable();
            $table->text('page_content');
            $table->text('page_content_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webpages');
    }
}
