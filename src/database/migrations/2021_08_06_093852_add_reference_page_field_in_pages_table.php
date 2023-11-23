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
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('reference_page_id')->nullable();
            $table->foreign('reference_page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('pages_reference_page_id_foreign');
            $table->dropColumn('reference_page_id');
        });
    }
};
