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
        Schema::create('arrest_and_apprehension_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->unsignedBigInteger('legal_status_id');
            $table->unsignedBigInteger('apprehension_type_id')->nullable();
            $table->string('cud_number')->nullable();
            $table->date('arrest_date')->nullable();
            $table->time('arrest_time')->nullable();
            $table->string('arrest_location')->nullable();
            $table->unsignedBigInteger('criminal_specialty_id')->nullable();
            $table->string('arrest_details')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('legal_status_id')->references('id')->on('legal_statuses');
            $table->foreign('apprehension_type_id')->references('id')->on('apprehension_types');
            $table->foreign('criminal_specialty_id')->references('id')->on('criminal_specialties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrest_and_apprehension_histories');
    }
};
