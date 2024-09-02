<?php

use App\Models\District;
use App\Models\Parish;
use App\Models\Subcounty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('gps')->nullable();
            $table->text('image')->nullable();
            $table->foreignIdFor(Parish::class)->nullable();
            $table->foreignIdFor(Subcounty::class)->nullable();
            $table->foreignIdFor(District::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
