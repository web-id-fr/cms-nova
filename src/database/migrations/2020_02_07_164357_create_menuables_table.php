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
        Schema::create('menuables', function (Blueprint $table) {
            $table->integer('menu_id');
            $table->integer('menuable_id');
            $table->string('menuable_type');
            $table->integer('order');
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menuables');
    }
};
