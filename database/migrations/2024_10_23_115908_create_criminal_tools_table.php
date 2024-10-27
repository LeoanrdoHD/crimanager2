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
        Schema::create('criminal_tools', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('criminal_id')->unsigned();
            $table->bigInteger('tool_type_id')->unsigned();
            $table->string('tool_details');
            $table->timestamps();
        
            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('tool_type_id')->references('id')->on('tools_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criminal_tools');
    }
};
