<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaceholderFieldForNewslettersComponentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('newsletters_component', function (Blueprint $table) {
            $table->longText('placeholder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('newsletters_component', function (Blueprint $table) {
            $table->dropColumn('placeholder');
        });
    }
}
