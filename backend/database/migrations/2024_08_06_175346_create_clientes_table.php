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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('numero_documento')->unique();
            $table->string('correo');
            $table->string('direccion');
            $table->string('nacionalidad');
            $table->string('procedencia');
            $table->date('fecha_de_nacimiento');
            $table->enum('estado_civil', ['soltero', 'casado', 'divorciado', 'viudo']);
            $table->string('telefono');
            $table->enum('estado', ['activo', 'inactivo'])->default('inactivo');
            $table->enum('tipo_de_huesped', ['Natural', 'Empresa']);
            $table->enum('tipo_de_documento', ['CI', 'pasaporte', 'carnet_de_extranjero', 'NIT']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
