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
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('launchpad_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('txid')->unique();
            $table->string('address');
            $table->string('qty');
            $table->string('amount');
            $table->decimal('usd', 12, 2)->default(0);
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trades');
    }
};
