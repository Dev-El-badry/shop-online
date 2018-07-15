<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('blog_title');
            $table->string('blog_title_ar');
            $table->string('keywords')->nullable();
            $table->text('blog_description')->nullable();
            $table->string('author', 60);
            $table->string('picture')->nullable();
            $table->string('headline');
            $table->text('blog_content');
            $table->text('blog_content_ar');
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
        Schema::dropIfExists('blogs');
    }
}
