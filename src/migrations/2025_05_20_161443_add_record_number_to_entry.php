<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('accpkg_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('record_number')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accpkg_entries', function (Blueprint $table) {
            $table->dropColumn('record_number');
        });
    }
};
