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
        Schema::create('extraditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id');
            $table->unsignedBigInteger('arrest_and_apprehension_history_id')->unsigned()->nullable();
            $table->unsignedBigInteger('conviction_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->date('extradition_date')->nullable();
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->foreign('arrest_and_apprehension_history_id')
            ->references('id')
            ->on('arrest_and_apprehension_histories')
            ->onDelete('cascade');
            $table->foreign('conviction_id')->references('id')->on('convictions');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extraditions');
    }
};
