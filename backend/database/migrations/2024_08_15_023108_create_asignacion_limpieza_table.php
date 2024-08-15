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
        Schema::create('asignacion_limpieza', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_personal')->constrained('personal_limpieza')->onDelete('cascade');
            $table->foreignId('id_habitacion')->constrained('habitaciones')->onDelete('cascade');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_limpieza');
    }
};
