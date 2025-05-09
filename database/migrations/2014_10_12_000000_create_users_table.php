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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('surnameP',100)->nullable();
            $table->string('surnameM',100)->nullable();
            $table->string('email',100)->unique();
            $table->string('phone',25)->nullable();
            $table->bigInteger('role_id')->nullable();
            $table->foreignId('departamento_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('num_empleado',35)->nullable();
            $table->string('avatar',250)->nullable();
            $table->boolean('status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
