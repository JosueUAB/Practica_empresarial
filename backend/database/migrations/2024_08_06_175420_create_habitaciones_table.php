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
            $table->string('numero');
            $table->enum('tipo', ['individual', 'doble', 'colectiva', 'matrimonial']);
            $table->integer('cantidad_camas');
            $table->string('descripcion');
            $table->float('costo');
            $table->boolean('tv')->default(false);
            $table->boolean('wifi')->default(false);
            $table->boolean('ducha')->default(false);
            $table->boolean('baño')->default(false);
            $table->boolean('disponible')->default(true);
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
