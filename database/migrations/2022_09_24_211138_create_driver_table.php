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
        Schema::create('driver', function (Blueprint $table) {
            $table->comment('');
            $table->unsignedBigInteger('staff_id')->primary();
            $table->string('licenseNo', 10);
            $table->integer('yearsExp')->nullable();
            $table->text('canDrive');
            $table->enum('status', ['Assigned', 'Unassigned'])->default('Unassigned');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('vhAssigned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
};
