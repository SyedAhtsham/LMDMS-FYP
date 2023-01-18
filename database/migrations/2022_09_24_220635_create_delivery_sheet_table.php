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
        Schema::create('delivery_sheet', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('deliverySheet_id');
            $table->string('deliverySheetCode', 30);
            $table->integer('noOfCons')->nullable();
            $table->double('fuelAssigned', 8, 2)->nullable();
            $table->unsignedBigInteger('area_id')->index('delivery_sheet_area_id_foreign');
            $table->unsignedBigInteger('driver_id')->nullable()->index('delivery_sheet_driver_id_foreign');
            $table->unsignedBigInteger('vehicle_id')->nullable()->index('delivery_sheet_vehicle_id_foreign');
            $table->unsignedBigInteger('supervisor_id')->nullable()->index('delivery_sheet_supervisor_id_foreign');
            $table->enum('status', ['checked-out', 'un-checked-out'])->default('un-checked-out');
            $table->timestamp('checkOutTime')->nullable();
            $table->timestamps();
            $table->boolean('finished')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_sheet');
    }
};
