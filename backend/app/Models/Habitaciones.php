<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';

    protected $fillable = [
        'numero_piso',
        'numero',
        'tipo',
        'cantidad_camas',
        'limite_personas',
        'descripcion',
        'costo',
        'tv',
        'wifi_id',
        'ducha',
        'baño',
        'disponible',
        'estado',
    ];

    // Define the relationship with the Wifi model
    public function wifi()
    {
        return $this->belongsTo(Wifi::class, 'wifi_id');
    }
}
