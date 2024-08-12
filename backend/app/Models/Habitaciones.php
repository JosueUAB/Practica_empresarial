<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';

    protected $fillable = [
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
        'estado'
    ];

    protected $attributes = [
        'tv' => false,
        'ducha' => false,
        'baño' => false,
        'disponible' => true,
        'estado' => 'disponible',
    ];

    public function wifi()
    {
        return $this->belongsTo(Wifi::class, 'wifi_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'id_habitacion');
    }

    public function asignacionLimpieza()
    {
        return $this->hasMany(AsignacionLimpieza::class, 'id_habitacion');
    }
}
