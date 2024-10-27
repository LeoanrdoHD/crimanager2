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
        Schema::create('criminal_aliases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->string('chapa', 50);
            $table->string('alias_name');
            $table->string('alias_identity_number');
            $table->bigInteger('nationality_id')->unsigned();
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_aliases');
    }
};
