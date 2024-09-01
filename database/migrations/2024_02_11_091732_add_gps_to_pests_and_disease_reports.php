<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGpsToPestsAndDiseaseReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pests_and_disease_reports', function (Blueprint $table) {
            $table->text('gps_lati')->nullable();
            $table->text('gps_longi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pests_and_disease_reports', function (Blueprint $table) {
            //
        });
    }
}
