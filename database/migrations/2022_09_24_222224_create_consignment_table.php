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
            $table->comment('');
            $table->bigIncrements('cons_id');
            $table->unsignedBigInteger('area_id')->index('area_id');
            $table->enum('status', ['Delivered', 'Returned'])->nullable();
            $table->string('consCode', 20);
            $table->double('consWeight', 8, 2);
            $table->double('consVolume', 8, 2);
            $table->string('shipper', 55);
            $table->string('consignee', 55);
            $table->text('toAddress');
            $table->text('fromAddress');
            $table->string('toContact', 20);
            $table->string('fromContact', 20);
            $table->text('consType');
            $table->unsignedBigInteger('deliverySheet_id')->nullable()->index('deliverySheet_id');
            $table->integer('COD')->nullable();
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
        Schema::dropIfExists('consignment');
    }
};
