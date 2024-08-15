<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteRecepcion extends Model
{
    use HasFactory;
    protected $fillable = ['id_usuario', 'tipo_reporte', 'contenido', 'ticket'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
