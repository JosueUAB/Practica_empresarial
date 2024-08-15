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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Clave foránea a la tabla de clientes
            $table->unsignedBigInteger('habitacion_id'); // Clave foránea a la tabla de habitaciones
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('numero_personas');
            $table->decimal('tarifa', 8, 2);
            $table->decimal('adelanto', 8, 2)->nullable();
            $table->decimal('saldo', 8, 2)->nullable();
            $table->string('tipo_comprobante')->nullable();
            $table->timestamps();

            // Relación con la tabla de clientes
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            // Relación con la tabla de habitaciones
            $table->foreign('habitacion_id')->references('id')->on('habitaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
