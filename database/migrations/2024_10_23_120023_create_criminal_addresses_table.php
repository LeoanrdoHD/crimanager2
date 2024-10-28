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
        Schema::create('criminal_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->string('street');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_addresses');
    }
};
