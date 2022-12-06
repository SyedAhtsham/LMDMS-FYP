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
        Schema::create('consignment', function (Blueprint $table) {
            $table->id('cons_id');
            $table->float('consWeight');
            $table->float('consVolume');
            $table->text('toAddress');
            $table->text('fromAddress');
            $table->string('toContact', 14);
            $table->string('fromContact', 14);
            $table->text('consType');
            $table->unsignedBigInteger('deliverySheet_id')->nullable();
            $table->integer('COD')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignment');
    }
};
