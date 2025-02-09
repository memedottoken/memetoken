<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_candles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('launchpad_id')->constrained()->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->string('timeframe'); // '1', '5', '15', '30', '60', '240', 'D', 'W'
            $table->decimal('open', 36, 18);
            $table->decimal('high', 36, 18);
            $table->decimal('low', 36, 18);
            $table->decimal('close', 36, 18);
            $table->decimal('volume', 36, 18);
            $table->integer('trades_count');
            $table->timestamps();

            // Composite index for efficient queries
            $table->unique(['launchpad_id', 'timeframe', 'timestamp']);
            $table->index(['launchpad_id', 'timeframe', 'timestamp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_candles');
    }
};
