<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accpkg_entries', function (Blueprint $table) {
            // Change description column type - adjust as needed
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accpkg_entries', function (Blueprint $table) {
            // Reverse the change - adjust the original type as needed
            $table->string('description', 255)->change();
        });
    }
};