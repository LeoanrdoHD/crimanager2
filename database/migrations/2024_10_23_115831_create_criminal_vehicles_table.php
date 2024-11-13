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
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->unsignedBigInteger('arrest_and_apprehension_history_id')->unsigned()->nullable();
            $table->unsignedBigInteger('vehicle_color_id')->unsigned();
            $table->unsignedBigInteger('type_id')->unsigned();
            $table->integer('year');
            $table->unsignedBigInteger('brand_id')->unsigned();
            $table->string('model');
            $table->unsignedBigInteger('industry_id')->unsigned();
            $table->string('license_plate');
            $table->unsignedBigInteger('vehicle_service_id')->unsigned();
            $table->text('details')->nullable();
            $table->boolean('itv_valid')->default(false);
            $table->string('user_name')->nullable();
            $table->string('user_ci')->nullable();
            $table->unsignedBigInteger('relationship_with_owner_id')->unsigned()->nullable();
            $table->text('observations')->nullable();
            $table->string('driver_name')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->foreign('arrest_and_apprehension_history_id')->references('id')->on('arrest_and_apprehension_histories')->onDelete('cascade');
            $table->foreign('vehicle_color_id')->references('id')->on('vehicle_colors');
            $table->foreign('type_id')->references('id')->on('vehicle_types');
            $table->foreign('brand_id')->references('id')->on('brand_vehicles');
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->foreign('vehicle_service_id')->references('id')->on('vehicle_services');
            $table->foreign('relationship_with_owner_id')->references('id')->on('relationship_with_owners');
        
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
