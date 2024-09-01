<?php

use App\Models\Garden;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGardenActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('garden_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('activity_category')->nullable();
            $table->string('description')->nullable();
            $table->date('date')->nullable();
            $table->string('person_responsible')->nullable();
            $table->string('remarks')->nullable();

            $table->foreign('garden_id')->references('id')->on('gardens')->onDelete('cascade');
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
        Schema::dropIfExists('garden_activities');
    }
}
