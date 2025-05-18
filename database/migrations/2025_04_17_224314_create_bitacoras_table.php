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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->string('descFalla', 200);
            $table->string('descSolucion', 200);
            $table->string('materialReq', 200);
            $table->integer('duracion');
            $table->unsignedBigInteger('idSolicitud'); 

            
            $table->foreign('idSolicitud')->references('id')->on('solicituds')->onDelete('restrict'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
