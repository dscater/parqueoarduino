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

    protected $appends = ["fecha_ft"];

    public function getFechaFTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha)) . ' ' . date("H:i a", strtotime($this->hora));
    }

    public function ingreso_salida()
    {
        return $this->belongsTo(IngresoSalida::class, 'ingreso_salida_id');
    }
}
