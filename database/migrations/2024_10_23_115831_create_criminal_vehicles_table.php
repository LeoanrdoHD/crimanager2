<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criminal_vehicles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->string('license_plate');
            $table->string('color', 50);
            $table->integer('year');
            $table->bigInteger('brand_id')->unsigned();
            $table->string('model');
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('nationality_id')->unsigned();
            $table->text('details')->nullable();
            $table->string('owner_name');
            $table->string('owner_ci');
            $table->string('relationship_with_owner');
            $table->boolean('itv_valid')->default(false);
            $table->text('observations')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('type_id')->references('id')->on('vehicle_types');
            $table->foreign('brand_id')->references('id')->on('brand_vehicles');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_vehicles');
    }
};
