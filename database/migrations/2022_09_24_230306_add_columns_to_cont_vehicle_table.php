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
        Schema::table('cont_vehicle', function (Blueprint $table) {
            //

            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicle');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cont_vehicle', function (Blueprint $table) {
            //
        });
    }
};
