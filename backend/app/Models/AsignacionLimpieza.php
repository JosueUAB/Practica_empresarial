<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionLimpieza extends Model
{
    use HasFactory;
    protected $fillable = ['id_personal', 'id_habitacion', 'fecha'];

    public function personal()
    {
        return $this->belongsTo(PersonalLimpieza::class, 'id_personal');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }
}
