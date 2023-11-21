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
        Schema::create('popins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('title')->nullable();
            $table->boolean('status')->nullable();
            $table->text('image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('button_1_title')->nullable();
            $table->longText('button_1_url')->nullable();
            $table->boolean('display_second_button')->nullable();
            $table->boolean('display_call_to_action')->nullable();
            $table->longText('button_2_title')->nullable();
            $table->longText('button_2_url')->nullable();
            $table->text('type')->nullable();
            $table->text('button_name')->nullable();
            $table->integer('delay')->nullable();
            $table->boolean('mobile_display')->nullable();
            $table->integer('max_display')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('popins');
    }
};
