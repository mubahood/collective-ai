<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfitLossColsToGardens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gardens', function (Blueprint $table) {
            $table->integer('income')->nullable();
            $table->integer('expense')->nullable();
            $table->integer('profit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gardens', function (Blueprint $table) {
            //
        });
    }
}
