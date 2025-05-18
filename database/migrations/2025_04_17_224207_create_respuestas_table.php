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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('asunto', 100); 
            $table->string('descripcion', 500); 
            $table->dateTime('fecha');
            $table->string('nombreVerifico', 150); 
            $table->integer('folio');
            $table->unsignedBigInteger('idCentroComputoJefe'); 
            $table->unsignedBigInteger('idTipoMantenimiento')->nullable();
            $table->unsignedBigInteger('idSolicitud'); 
            $table->unsignedBigInteger('idTipoServicio')->nullable();
            
            $table->foreign('idCentroComputoJefe')->references('id')->on('centro_computo_jefes')->onDelete('restrict');
            $table->foreign('idTipoMantenimiento')->references('id')->on('tipo_mantenimientos')->onDelete('restrict'); 
            $table->foreign('idTipoServicio')->references('id')->on('tipo_servicios')->onDelete('restrict');
            $table->foreign('idSolicitud')->references('id')->on('solicituds')->onDelete('restrict'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
