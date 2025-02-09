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
        Schema::create('holders', function (Blueprint $table) { 
			$table->bigIncrements('id');
			$table->foreignId('launchpad_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
			$table->foreignId('user_id')->nullable()->constrained();
			$table->string('address');
			$table->string('qty');
			$table->boolean('prebond')->default(false);
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
        Schema::drop('holders');
    }
};
