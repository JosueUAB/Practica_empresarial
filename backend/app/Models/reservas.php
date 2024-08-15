<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservas extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'cliente_id',
        'habitacion_id',
        'fecha_inicio',
        'fecha_fin',
        'numero_personas',
        'tarifa',
        'adelanto',
        'saldo',
        'tipo_comprobante',
    ];

    // Relación con Clientes
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Relación con Habitaciones
    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, 'habitacion_id');
    }
}
