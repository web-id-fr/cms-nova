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
        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('reference_page_id')->nullable();
            $table->foreign('reference_page_id')->references('id')->on('templates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign('templates_reference_page_id_foreign');
            $table->dropColumn('reference_page_id');
        });
    }
};
