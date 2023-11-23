<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('popin_page', function (Blueprint $table) {
            $table->unsignedBigInteger('popin_id');
            $table->foreign('popin_id')->references('id')->on('popins');
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('popin_page');
    }
};
