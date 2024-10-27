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
        Schema::create('criminal_fingerprints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id');
            $table->json('fingerprint_data');
            $table->timestamps();

            // Relaciones (Foreign Key)
            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_fingerprints');
    }
};
