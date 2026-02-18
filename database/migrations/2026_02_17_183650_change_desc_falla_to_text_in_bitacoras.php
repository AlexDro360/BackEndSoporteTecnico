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
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->text('descFalla')->change();
            $table->text('descSolucion')->change();
            $table->text('materialReq')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->string('descFalla')->change();
            $table->string('descSolucion')->change();
            $table->string('materialReq')->change();
        });
    }
};
