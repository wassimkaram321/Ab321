<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar');
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image');
            // $table->double('distance')->nullable();
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_open')->default(0);
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->float('avg_rating', 2, 1)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('package_id');
            $table->integer('visits');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
