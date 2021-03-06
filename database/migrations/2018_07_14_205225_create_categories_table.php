<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cat_title', 500);
            $table->string('cat_url')->unqiue();
            $table->string('cat_url_ar')->unqiue();
            $table->unsignedInteger('cat_parent_id')->default(0);
            $table->unsignedInteger('priority')->default(0);
            $table->string('posted_info')->nullable();
            $table->string('picture')->nullable();
            $table->boolean('for_what')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
