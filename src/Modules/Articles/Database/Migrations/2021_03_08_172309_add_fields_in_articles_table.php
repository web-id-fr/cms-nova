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
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('order')->nullable();
            $table->boolean('not_display_in_list')->default(false);
            $table->integer('article_type');
            $table->longText('quotation')->nullable();
            $table->longText('author')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('not_display_in_list');
            $table->dropColumn('article_type');
            $table->dropColumn('quotation');
            $table->dropColumn('author');
        });
    }
};
