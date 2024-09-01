<?php

use App\Models\District;
use App\Models\Parish;
use App\Models\Subcounty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToGardens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gardens', function (Blueprint $table) {
            $table->text('gps_lati')->nullable();
            $table->text('gps_longi')->nullable();
            $table->date('harvest_date')->nullable();
            $table->string('is_harvested')->nullable()->default('No');
            $table->text('harvest_quality')->nullable();
            $table->integer('quantity_harvested')->nullable();
            $table->integer('quantity_planted')->nullable();
            $table->text('harvest_notes')->nullable();
            $table->foreignIdFor(District::class)->onDelete('cascade');
            $table->foreignIdFor(Subcounty::class)->onDelete('cascade');
            $table->foreignIdFor(Parish::class)->onDelete('cascade');
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
