<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGardensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gardens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('variety_id');
            $table->string('name')->nullable();
            $table->string('garden_size')->nullable();
            $table->string('ownership')->nullable();
            $table->string('planting_date')->nullable();
            $table->string('harvest_date')->nullable();
            $table->string('seed_class')->nullable();
            $table->string('certified_seller')->nullable();
            $table->string('name_of_seller')->nullable();
            $table->string('seller_location')->nullable();
            $table->string('seller_contact')->nullable();
            $table->string('purpose_of_seller')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('variety_id')->references('id')->on('groundnut_varieties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gardens');
    }
}
