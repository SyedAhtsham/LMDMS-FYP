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
        Schema::table('vehicle_assignment', function (Blueprint $table) {
            $table->foreign(['assignedBy'], 'vehicle_assignment_ibfk_1')->references(['staff_id'])->on('staff');
            $table->foreign(['vehicle_id'])->references(['vehicle_id'])->on('vehicle');
            $table->foreign(['assignedTo'], 'vehicle_assignment_staff_id_foreign')->references(['staff_id'])->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_assignment', function (Blueprint $table) {
            $table->dropForeign('vehicle_assignment_ibfk_1');
            $table->dropForeign('vehicle_assignment_vehicle_id_foreign');
            $table->dropForeign('vehicle_assignment_staff_id_foreign');
        });
    }
};
