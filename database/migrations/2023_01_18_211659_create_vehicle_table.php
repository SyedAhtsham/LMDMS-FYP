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
            $table->comment('');
            $table->bigIncrements('vehicle_id');
            $table->string('vehicleCode', 10);
            $table->enum('assignStatus', ['Assigned', 'Unassigned'])->default('Unassigned');
            $table->string('plateNo', 12);
            $table->string('vehicleModel', 6)->nullable();
            $table->enum('condition', ['Good', 'Bad', 'Normal']);
            $table->float('mileage', 10, 0)->nullable()->default(15);
            $table->enum('status', ['Active', 'Idle', 'In-Workshop'])->default('Idle');
            $table->boolean('assignmentStatus')->default(false);
            $table->boolean('dsAssigned')->default(false);
            $table->string('make', 20)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('vehicleType_id')->index('vehicle_vehicletype_id_foreign');
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
        Schema::dropIfExists('vehicle');
    }
};
