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
            $table->foreign(['area_id'])->references(['area_id'])->on('area');
            $table->foreign(['supervisor_id'])->references(['staff_id'])->on('staff');
            $table->foreign(['driver_id'])->references(['staff_id'])->on('staff');
            $table->foreign(['vehicle_id'])->references(['vehicle_id'])->on('vehicle');
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
            $table->dropForeign('delivery_sheet_area_id_foreign');
            $table->dropForeign('delivery_sheet_supervisor_id_foreign');
            $table->dropForeign('delivery_sheet_driver_id_foreign');
            $table->dropForeign('delivery_sheet_vehicle_id_foreign');
        });
    }
};
