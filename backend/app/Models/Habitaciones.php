<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
    use HasFactory;
    protected $table  ='habitaciones';
    protected $fillable = [
        'numero',
        'tipo',
        'cantidad_camas',
        'descripcion',
        'costo',
        'tv',
        'wifi',
        'ducha',
        'baño',
        'disponible'
    ];
}
