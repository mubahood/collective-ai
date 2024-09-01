<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('provider_name')->nullable();
            $table->text('business_name')->nullable();
            $table->text('details')->nullable();
            $table->text('services_offered')->nullable();
            $table->text('gps_lat')->nullable();
            $table->text('gps_long')->nullable();
            $table->text('photo')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_number_2')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
