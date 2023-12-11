<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    use HasFactory;

    protected $fillable = [
        "ingreso_salida_id",
        "tiempo",
        "costo",
        "fecha",
        "hora",
        "visto"
    ];

    public function ingreso_salida()
    {
        return $this->belongsTo(IngresoSalida::class, 'ingreso_salida_id');
    }
}
