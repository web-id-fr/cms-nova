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
        Schema::create('menu_custom_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('title');
            $table->longText('url')->nullable();
            $table->string('target')->default('_self');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menu_custom_items');
    }
};
