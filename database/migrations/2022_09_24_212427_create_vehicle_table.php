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
        Schema::create('vehicle', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('plateNo', 12);
            $table->string('model', 6)->nullable();
            $table->enum('condition', ["Good", "Bad", "Normal"]);
            $table->enum('status', ["Active", "Idle", "In-Workshop"]);
            $table->string('make', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
};
