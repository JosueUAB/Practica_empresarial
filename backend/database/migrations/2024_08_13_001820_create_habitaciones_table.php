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
            $table->integer('numero_piso');
            $table->string('numero', 20);
            $table->enum('tipo', ['individual', 'doble', 'colectiva', 'matrimonial', 'familiar']);
            $table->integer('cantidad_camas');
            $table->integer('limite_personas');
            $table->text('descripcion')->nullable();
            $table->float('costo');
            $table->boolean('tv')->default(false);
            $table->unsignedBigInteger('wifi_id')->nullable();
            $table->boolean('ducha')->default(false);
            $table->boolean('banio')->default(false);
            $table->enum('estado', ['disponible', 'mantenimiento', 'limpieza','ocupado','reservado'])->default('disponible');
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('wifi_id')->references('id')->on('wifi')->onDelete('set null');
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
