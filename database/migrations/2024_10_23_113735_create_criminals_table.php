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
            $table->string('last_nameP', 50);
            $table->string('last_nameM', 50);
            $table->string('identity_number', 25)->unique();
            $table->date('date_of_birth');
            $table->integer('age');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->boolean('is_member_of_criminal_organization')->nullable();
            $table->boolean('use_vehicle')->nullable();
            $table->boolean('use_cellular')->nullable();
            $table->unsignedBigInteger('civil_state_id')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->string('alias_name', 100)->nullable();
            $table->unsignedBigInteger('ocupation_id')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('civil_state_id')->references('id')->on('civil_states');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->foreign('ocupation_id')->references('id')->on('ocupations');
            
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
