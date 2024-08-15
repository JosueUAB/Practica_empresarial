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
        Schema::create('registro_caja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_caja')->constrained('caja')->onDelete('cascade');
            $table->enum('tipo_operacion', ['ingreso', 'egreso']);
            $table->float('monto');
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_caja');
    }
};
