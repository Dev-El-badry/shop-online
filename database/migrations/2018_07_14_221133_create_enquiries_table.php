<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sent_to');
            $table->unsignedInteger('sent_by');
            $table->string('subject');
            $table->text('message');
            $table->tinyInteger('opened');
            $table->string('code', 10);
            $table->tinyInteger('urgent');
            $table->tinyInteger('ranking');
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
        Schema::dropIfExists('enquiries');
    }
}
