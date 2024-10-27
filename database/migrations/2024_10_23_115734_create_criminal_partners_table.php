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
        Schema::create('criminal_partners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->string('partner_name');
            $table->string('partner_ci');
            $table->bigInteger('relationship_type_id')->unsigned();
            $table->string('partner_address');
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('relationship_type_id')->references('id')->on('relationship_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_partners');
    }
};
