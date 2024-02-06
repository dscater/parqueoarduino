<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre"
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class, 'piso_id');
    }
}
