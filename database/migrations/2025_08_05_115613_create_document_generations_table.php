<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_generations', function (Blueprint $table) {
            $table->id();
            
            // Información del documento
            $table->string('document_id')->unique()->comment('ID único del documento generado');
            $table->unsignedBigInteger('criminal_id')->comment('ID del delincuente');
            $table->enum('document_type', ['rapido', 'completo'])->default('rapido')->comment('Tipo de documento generado');
            
            // Firma digital y seguridad
            $table->text('signature')->comment('Firma digital HMAC del documento');
            $table->string('data_hash')->comment('Hash de los datos críticos');
            $table->timestamp('timestamp')->comment('Momento exacto de generación');
            
            // Estado del documento (MEJORA 1)
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Estado actual del documento');
            $table->timestamp('deactivated_at')->nullable()->comment('Fecha de desactivación');
            $table->unsignedBigInteger('deactivated_by')->nullable()->comment('Usuario que desactivó');
            $table->string('deactivation_reason')->nullable()->comment('Razón de la desactivación');
            
            // Auditoría de generación
            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuario que generó el documento');
            $table->ipAddress('ip_address')->nullable()->comment('IP desde donde se generó');
            $table->text('user_agent')->nullable()->comment('User Agent del navegador');
            
            // Timestamps automáticos
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index(['criminal_id', 'status'], 'idx_criminal_status');
            $table->index(['criminal_id', 'created_at'], 'idx_criminal_created');
            $table->index(['status', 'created_at'], 'idx_status_created');
            $table->index(['document_type', 'status'], 'idx_type_status');
            $table->index('timestamp', 'idx_timestamp');
            $table->index('user_id', 'idx_user');
            
            // Claves foráneas
            $table->foreign('criminal_id')
                  ->references('id')
                  ->on('criminals')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
                  
            $table->foreign('deactivated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_generations');
    }
}