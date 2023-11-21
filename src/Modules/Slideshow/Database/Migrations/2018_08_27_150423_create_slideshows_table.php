<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideshowsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('title')->nullable();
            $table->boolean('js_controls')->default(false);
            $table->boolean('js_animate_auto')->default(false);
            $table->integer('js_speed')->default(5000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('slideshows');
    }
}
