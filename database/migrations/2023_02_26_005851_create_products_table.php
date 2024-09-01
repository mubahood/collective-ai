<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Administrator::class);
            $table->text('name')->nullable();
            $table->text('type')->nullable();
            $table->text('photo')->nullable();
            $table->text('details')->nullable();
            $table->text('price')->nullable();
            $table->text('offer_type')->nullable();
            $table->text('state')->nullable();
            $table->text('category')->nullable();
            $table->text('subcounty_id')->nullable();
            $table->text('district_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
