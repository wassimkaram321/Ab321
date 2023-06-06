<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('is_active')->default(0);
            $table->enum('priority', ['high', 'medium', 'low'])->default('high');
            $table->string('url')->nullable();
            $table->bigInteger('click_counts')->default(0);
            $table->string('image');
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
