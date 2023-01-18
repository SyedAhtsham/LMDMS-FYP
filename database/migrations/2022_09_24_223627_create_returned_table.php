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
        Schema::create('returned', function (Blueprint $table) {
            $table->comment('');
            $table->unsignedBigInteger('cons_id')->index('returned_cons_id_foreign');
            $table->text('returnReason')->nullable();
            $table->timestamp('returnDate')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returned');
    }
};
