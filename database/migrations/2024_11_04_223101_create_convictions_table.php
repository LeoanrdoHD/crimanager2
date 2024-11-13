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
        Schema::create('convictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id')->unsigned();
            $table->unsignedBigInteger('arrest_and_apprehension_history_id')->unsigned()->nullable();
            $table->unsignedBigInteger('detention_type_id')->nullable();
            $table->timestamps();


            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('arrest_and_apprehension_history_id')
            ->references('id')
            ->on('arrest_and_apprehension_histories')
            ->onDelete('cascade');
            $table->foreign('detention_type_id')->references('id')->on('detention_types');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convictions');
    }
};
