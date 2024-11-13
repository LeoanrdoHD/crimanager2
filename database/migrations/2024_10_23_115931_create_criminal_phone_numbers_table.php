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
        Schema::create('criminal_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->unsignedBigInteger('arrest_and_apprehension_history_id')->unsigned()->nullable();
            $table->string('phone_number');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->string('imei_number')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->foreign('arrest_and_apprehension_history_id', 'fk_arrest_history_id')
            ->references('id')
            ->on('arrest_and_apprehension_histories')
            ->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_phone_numbers');
    }
};
