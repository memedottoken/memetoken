<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Truncate the table first
        DB::table('holders')->truncate();

        Schema::table('holders', function (Blueprint $table) {
            $table->unique(['launchpad_id', 'address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('holders', function (Blueprint $table) {
            $table->dropUnique(['launchpad_id', 'address']);
        });
    }
};
