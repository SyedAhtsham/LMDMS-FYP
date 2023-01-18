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
        Schema::create('cont_vehicle', function (Blueprint $table) {
            $table->comment('');
            $table->unsignedBigInteger('vehicle_id')->primary();
            $table->integer('rentPerDay');
            $table->date('dateOfContract');
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
        Schema::dropIfExists('cont_vehicle');
    }
};
