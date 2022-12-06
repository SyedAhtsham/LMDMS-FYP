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
        Schema::table('delivery_sheet', function (Blueprint $table) {
            //
            $table->integer('noOfCons')->after('deliverySheetCode');
            $table->foreign('area_id')->references('area_id')->on('area');

            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicle');
            $table->foreign('supervisor_id')->references('staff_id')->on('staff');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_sheet', function (Blueprint $table) {
            //
        });
    }
};
