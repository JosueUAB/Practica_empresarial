<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = 'clientes';

    protected $fillable = [
       'nombre',
        'apellido',
        'numero_documento',
        'correo',
        'direccion',
        'nacionalidad',
        'procedencia',
        'fecha_de_nacimiento',
        'estado_civil',
        'telefono',
        'estado',
        'tipo_de_huesped',
        'tipo_de_documento'
    ];


    protected $attributes = [
        'estado' => 'inactivo',
    ];
}
