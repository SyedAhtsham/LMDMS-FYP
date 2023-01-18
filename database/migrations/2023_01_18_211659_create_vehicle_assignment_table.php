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
        Schema::create('vehicle_assignment', function (Blueprint $table) {
            $table->comment('');
            $table->unsignedBigInteger('vehicle_id')->primary();
            $table->unsignedBigInteger('assignedTo')->index('vehicle_assignment_staff_id_foreign');
            $table->unsignedBigInteger('assignedBy')->nullable()->index('assignedBy');
            $table->timestamp('dateAssigned')->useCurrentOnUpdate()->useCurrent();
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
        Schema::dropIfExists('vehicle_assignment');
    }
};
