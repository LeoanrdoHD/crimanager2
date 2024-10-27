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
        Schema::create('criminal_organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id');
            $table->unsignedBigInteger('organization_id');
            $table->string('role_in_organization', 100);
            $table->timestamps();

            // Relaciones (Foreign Keys)
            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_organizations');
    }
};
