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
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->mediumText('face_photo')->nullable();
            $table->mediumText('frontal_photo')->nullable();
            $table->mediumText('full_body_photo')->nullable();
            $table->mediumText('profile_izq_photo')->nullable();
            $table->mediumText('profile_der_photo')->nullable();
            $table->mediumText('aditional_photo')->nullable();
            $table->mediumText('barra_photo')->nullable();
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
