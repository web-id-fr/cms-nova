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
        Schema::table('menu_custom_items', function (Blueprint $table) {
            $table->integer('type_link')->nullable();
            $table->integer('form_id')->nullable();
            $table->string('target')->default('_self')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('menu_custom_items', function (Blueprint $table) {
            $table->dropColumn('type_link');
            $table->dropColumn('form_id');
            $table->string('target')->default('_self')->nullable(false)->change();
        });
    }
};
