<?php

use App\Models\Commodity;
use App\Models\DataCollectionGenerator;
use App\Models\District;
use App\Models\Market;
use App\Models\Parish;
use App\Models\Subcounty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(DataCollectionGenerator::class);
            $table->date('due_date');
            $table->foreignIdFor(Commodity::class);
            $table->foreignIdFor(Market::class);
            $table->foreignIdFor(Parish::class);
            $table->foreignIdFor(Subcounty::class);
            $table->foreignIdFor(District::class);
            $table->text('gps')->nullable();
            $table->integer('wholesale_price')->nullable();
            $table->integer('retail_price')->nullable();
            $table->text('measurement_unit')->nullable();
            $table->string('price_direction')->nullable()->default('Stable');
            $table->text('comment')->nullable();
            $table->string('status')->nullable()->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_records');
    }
}
