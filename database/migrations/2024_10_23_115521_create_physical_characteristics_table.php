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
            $table->bigInteger('criminal_id')->unsigned();
            $table->float('height');
            $table->float('weight');
            $table->string('sex', 50);
            $table->bigInteger('criminal_gender_id')->unsigned();
            $table->bigInteger('skin_color_id')->unsigned();
            $table->bigInteger('eye_type_id')->unsigned();
            $table->bigInteger('ear_type_id')->unsigned();
            $table->bigInteger('lip_type_id')->unsigned();
            $table->bigInteger('nose_type_id')->unsigned();
            $table->string('complexion', 50);
            $table->text('distinctive_marks')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('criminal_gender_id')->references('id')->on('criminal_genders');
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
