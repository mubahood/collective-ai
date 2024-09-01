<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('garden_id');
            $table->string('activity_category');
            $table->string('description');
            $table->date('date');
            $table->string('person_responsible');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('garden_id')->references('id')->on('gardens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_records');
    }
}
