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
        Schema::table('popin_page', function (Blueprint $table) {
            $table->dropForeign('popin_page_popin_id_foreign');
            $table->dropForeign('popin_page_page_id_foreign');
            $table->foreign('popin_id')->references('id')->on('popins')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('popin_page', function (Blueprint $table) {
            $table->dropForeign('popin_page_popin_id_foreign');
            $table->dropForeign('popin_page_page_id_foreign');
            $table->foreign('popin_id')->references('id')->on('popins');
            $table->foreign('page_id')->references('id')->on('pages');
        });
    }
};
