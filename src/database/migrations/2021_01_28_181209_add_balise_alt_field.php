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
        Schema::table('popins', function (Blueprint $table) {
            $table->longText('image_alt')->nullable();
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->longText('opengraph_picture_alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('popins', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('opengraph_picture_alt');
        });
    }
};
