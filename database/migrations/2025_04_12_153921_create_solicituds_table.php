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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idUser')->nullable();
            $table->text('descripcionUser')->nullable();
            $table->date('fechaRevision')->nullable();
            $table->text('descripcionFalla')->nullable();
            $table->date('fechaSolucion')->nullable();
            $table->text('descripcionSolucion')->nullable();
            $table->text('materialRequerido')->nullable();
            $table->bigInteger('idTipo')->nullable();
            $table->bigInteger('idEstado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
