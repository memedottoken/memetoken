<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poolstats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('launchpad_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('token0_price', 36, 18);
            $table->decimal('token1_price', 36, 18);
            $table->decimal('tvl_usd', 36, 18);
            $table->decimal('volume_24h', 36, 18);
            $table->decimal('fee_tier', 5, 2);
            $table->integer('transactions_24h')->default(0);
            $table->integer('total_transactions')->default(0);
            $table->decimal('liquidity', 36, 18);
            $table->decimal('price_change_1h', 8, 4);
            $table->decimal('price_change_24h', 8, 4);
            $table->decimal('price_change_7d', 8, 4);
            $table->decimal('min_price_24h', 36, 18);
            $table->decimal('max_price_24h', 36, 18);
            $table->timestamp('timestamp');
            $table->timestamps();
            $table->softDeletes();
            // Indexes
            $table->unique(['launchpad_id', 'timestamp']);
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('poolstats');
    }
};
