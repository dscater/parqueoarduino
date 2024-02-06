<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    use HasFactory;

    protected $fillable = [
        "piso_id",
        "nombre",
        "nro_espacio",
        "estado",
    ];

    public function piso()
    {
        return $this->belongsTo(Piso::class, 'piso_id');
    }
}
