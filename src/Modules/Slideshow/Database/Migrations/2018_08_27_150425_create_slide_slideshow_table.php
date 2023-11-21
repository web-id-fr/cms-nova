<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideSlideshowTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('slide_slideshow', function (Blueprint $table) {
            $table->bigInteger('slideshow_id')->unsigned();
            $table->foreign('slideshow_id')->references('id')->on('slideshows')->onDelete('cascade');
            $table->bigInteger('slide_id')->unsigned();
            $table->foreign('slide_id')->references('id')->on('slides')->onDelete('cascade');
            $table->integer('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('slide_slideshow');
    }
}
