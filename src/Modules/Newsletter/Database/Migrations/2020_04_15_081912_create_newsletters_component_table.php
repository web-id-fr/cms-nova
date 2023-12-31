<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersComponentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('newsletters_component', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('title')->nullable();
            $table->longText('cta_name')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('newsletters_component');
    }
}
