<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCaja extends Model
{
    use HasFactory;
    protected $fillable = ['id_caja', 'tipo_operacion', 'monto', 'descripcion', 'fecha'];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }
}
