<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservas extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'id_cliente',
        'id_habitacion',
        'fecha_inicio',
        'fecha_fin',
        'numero_personas',
        'tarifa',
        'descripcion',
        'adelanto',
        'saldo',
        'tipo_comprobante'
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, 'id_habitacion');
    }
}
