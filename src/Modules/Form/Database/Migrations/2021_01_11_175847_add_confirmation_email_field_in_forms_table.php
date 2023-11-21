<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationEmailFieldInFormsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('confirmation_email_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('confirmation_email_name');
        });
    }
}
