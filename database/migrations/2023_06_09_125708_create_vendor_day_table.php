<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_day', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->onDelete('cascade')->nullable();
            $table->foreignId('day_id')->onDelete('cascade')->nullable();
            $table->time('open_at');
            $table->time('close_at');
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
        Schema::dropIfExists('vendor_day');
    }
}
