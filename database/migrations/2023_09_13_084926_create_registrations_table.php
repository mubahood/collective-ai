<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('category')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('level_of_education')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('sub_county')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('farmers_group')->nullable();
            $table->string('farming_experience')->nullable();
            $table->string('production_scale')->nullable();
            $table->string('number_of_dependants')->nullable();
            $table->string('company_information')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('registration_number')->nullable();                             ;
            $table->string('district')->nullable();
            $table->string('specialization')->nullable();
            $table->string('service_provider_name')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('email_address')->nullable();
            $table->string('services_offered')->nullable();
            $table->string('service_category')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
