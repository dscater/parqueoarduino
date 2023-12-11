<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoSalida extends Model
{
    use HasFactory;

    protected $fillable = [
        "espacio_id",
        "fecha_ingreso",
        "hora_ingreso",
        "fecha_salida",
        "hora_salida",
        "tiempo",
    ];

    protected $appends = ["fecha_ingreso_ft", "fecha_salida_ft", "tiempo_t"];

    public function getFechaIngresoFTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_ingreso)) . ' ' . date("H:i a", strtotime($this->hora_ingreso));
    }

    public function getFechaSalidaFTAttribute()
    {
        if ($this->fecha_salida && $this->hora_salida)
            return date("d/m/Y", strtotime($this->fecha_salida)) . ' ' . date("H:i a", strtotime($this->hora_salida));
        return 'PENDIENTE';
    }

    public function getTiempoTAttribute()
    {
        if ($this->tiempo)
            return $this->tiempo . " mins.";
        return 'PENDIENTE';
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }

    public function cobro()
    {
        return $this->hasOne(Cobro::class, 'ingreso_salida_id');
    }
}
