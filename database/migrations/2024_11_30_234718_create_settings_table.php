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
        Schema::create('settings', function (Blueprint $table) { 
			$table->bigIncrements('id');
			$table->string('logo')->nullable();
			$table->string('name')->nullable();
			$table->string('twitter')->nullable();
			$table->string('youtube')->nullable();
			$table->string('telegram_group')->nullable();
			$table->string('telegram_channel')->nullable();
			$table->string('discord')->nullable();
			$table->string('documentation')->nullable();
			$table->string('rpc')->default('ankr');
			$table->string('ankr')->nullable();
			$table->string('infura')->nullable();
			$table->string('blast')->nullable();
			$table->boolean('chat')->default(true);
			$table->boolean('featured')->default(false);
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
        Schema::drop('settings');
    }
};
