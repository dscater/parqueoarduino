<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index(Request $request)
    {
        $espacios = Espacio::all();
        return response()->JSON(['espacios' => $espacios, 'total' => count($espacios)], 200);
    }
}
