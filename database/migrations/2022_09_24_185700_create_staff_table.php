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
        Schema::create('staff', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('staff_id');
            $table->string('staffCode', 10);
            $table->string('name', 60);
            $table->string('email', 100);
            $table->string('contact', 20);
            $table->text('address')->nullable();
            $table->string('cnic', 15);
            $table->enum('position', ['Manager', 'Supervisor', 'Driver']);
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
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
        Schema::dropIfExists('staff');
    }
};
