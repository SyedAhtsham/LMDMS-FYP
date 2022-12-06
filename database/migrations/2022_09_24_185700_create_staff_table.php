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
            $table->id('staff_id');
            $table->string('name', 60);
            $table->string('email', 100);
            $table->text('address')->nullable();
            $table->string('CNIC', 15);
            $table->enum('position', ["Manager", "Supervisor", "Driver"]);
            $table->date('DOB')->nullable();
            $table->date('dateJoined')->nullable();
            $table->integer('salary')->default(0);
            $table->enum('gender', ["M", "F", "O"])->nullable();
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
        Schema::dropIfExists('staff');
    }
};
