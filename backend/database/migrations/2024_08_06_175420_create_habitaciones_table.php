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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20);
            $table->enum('tipo', ['individual', 'doble', 'colectiva', 'matrimonial', 'familiar']);
            $table->integer('cantidad_camas');
            $table->integer('limite_personas');
            $table->text('descripcion')->nullable();
            $table->float('costo');
            $table->boolean('tv')->default(false);
            $table->foreignId('wifi_id')->nullable()->constrained('wifi')->onDelete('set null');
            $table->boolean('ducha')->default(false);
            $table->boolean('baño')->default(false);
            $table->boolean('disponible')->default(true);
            $table->enum('estado', ['disponible', 'mantenimiento', 'limpieza'])->default('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
