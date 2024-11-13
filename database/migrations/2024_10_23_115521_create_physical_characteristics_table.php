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
        Schema::create('physical_characteristics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->float('height');
            $table->float('weight');
            $table->string('sex', 50);
            $table->unsignedBigInteger('confleccion_id')->nullable();
            $table->unsignedBigInteger('criminal_gender_id')->nullable();
            $table->unsignedBigInteger('skin_color_id')->nullable();
            $table->unsignedBigInteger('eye_type_id')->nullable();
            $table->unsignedBigInteger('ear_type_id')->nullable();
            $table->unsignedBigInteger('lip_type_id')->nullable();
            $table->unsignedBigInteger('nose_type_id')->nullable();
           
            $table->string('distinctive_marks',200);
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('criminal_gender_id')->references('id')->on('criminal_genders');
            $table->foreign('confleccion_id')->references('id')->on('confleccions');
            $table->foreign('skin_color_id')->references('id')->on('skin_colors');
            $table->foreign('eye_type_id')->references('id')->on('eye_types');
            $table->foreign('ear_type_id')->references('id')->on('ear_types');
            $table->foreign('lip_type_id')->references('id')->on('lip_types');
            $table->foreign('nose_type_id')->references('id')->on('nose_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_characteristics');
    }
};
