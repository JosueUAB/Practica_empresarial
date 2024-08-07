<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model
{
    use HasFactory;
    protected $table  ='ingresos';
    protected $fillable = [
        'fecha',
        'monto_total',
    ];
}
