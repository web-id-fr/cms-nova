<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToImageFieldInSlidesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->longText('image_alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
            $table->dropColumn('image_alt');
        });
    }
}
