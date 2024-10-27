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
        Schema::create('criminals', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('identity_number', 100);
            $table->date('date_of_birth');
            $table->integer('age');
            $table->boolean('is_member_of_criminal_organization');
            $table->boolean('use_vehicle');
            $table->unsignedBigInteger('civil_state_id')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('criminal_specialty_id')->nullable();
            $table->timestamps();

            $table->foreign('civil_state_id')->references('id')->on('civil_states');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->foreign('criminal_specialty_id')->references('id')->on('criminal_specialties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminals');
    }
};
