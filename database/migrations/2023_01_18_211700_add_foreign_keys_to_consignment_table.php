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
        Schema::table('consignment', function (Blueprint $table) {
            $table->foreign(['area_id'], 'consignment_ibfk_1')->references(['area_id'])->on('area');
            $table->foreign(['deliverySheet_id'], 'consignment_ibfk_2')->references(['deliverySheet_id'])->on('delivery_sheet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignment', function (Blueprint $table) {
            $table->dropForeign('consignment_ibfk_1');
            $table->dropForeign('consignment_ibfk_2');
        });
    }
};
