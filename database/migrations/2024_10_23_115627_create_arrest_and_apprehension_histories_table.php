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
        Schema::create('arrest_and_apprehension_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->bigInteger('legal_status_id')->unsigned();
            $table->bigInteger('detention_type_id')->unsigned();
            $table->date('arrest_date');
            $table->time('arrest_time');
            $table->string('arrest_location');
            $table->string('arrest_details')->nullable();
            $table->bigInteger('apprehension_type_id')->unsigned();
            $table->bigInteger('prison_id')->unsigned();
            $table->date('prison_entry_date')->nullable();
            $table->date('prison_release_date')->nullable();
            $table->string('house_arrest_address')->nullable();
            $table->string('cud_number')->nullable();
            $table->date('extradition_date')->nullable();
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('legal_status_id')->references('id')->on('legal_statuses');
            $table->foreign('detention_type_id')->references('id')->on('detention_types');
            $table->foreign('apprehension_type_id')->references('id')->on('apprehension_types');
            $table->foreign('prison_id')->references('id')->on('prisons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrest_and_apprehension_histories');
    }
};
