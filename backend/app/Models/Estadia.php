<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadia extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'habitacion_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_pagar'
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class);
    }
}
