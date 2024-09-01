<?php

use App\Models\Crop;
use App\Models\District;
use App\Models\Garden;
use App\Models\Parish;
use App\Models\PestsAndDisease;
use App\Models\Subcounty;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePestsAndDiseaseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pests_and_disease_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(PestsAndDisease::class)->onDelete('cascade');
            $table->foreignIdFor(Garden::class)->onDelete('cascade');
            $table->foreignIdFor(Crop::class)->onDelete('cascade');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(District::class)->onDelete('cascade');
            $table->foreignIdFor(Subcounty::class)->onDelete('cascade');
            $table->foreignIdFor(Parish::class)->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->text('video')->nullable();
            $table->text('expert_answer')->nullable();
            $table->text('expert_answer_photo')->nullable();
            $table->text('expert_answer_video')->nullable();
            $table->text('expert_answer_audio')->nullable();
            $table->text('expert_answer_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pests_and_disease_reports');
    }
}
