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
        Schema::create('centro_computo_jefes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 50);
            $table->string('apellidoP', 50);
            $table->string('apellidoM', 50);
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_computo_jefes');
    }
};
