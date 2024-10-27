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
        Schema::create('photographs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->string('frontal_photo');
            $table->string('full_body_photo');
            $table->string('profile_izq_photo');
            $table->string('profile_der_photo');
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographs');
    }
};
