<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePestsAndDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pests_and_diseases', function (Blueprint $table) {
            $table->id();
            $table->string('garden_location')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('variety_id')->nullable();
            $table->string('category')->nullable();
            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('pests_and_diseases');
    }
}
