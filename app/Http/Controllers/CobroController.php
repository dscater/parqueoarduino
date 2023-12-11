<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    public function verifica_cobro(Request $request)
    {
        $id = $request->ultimo_id;
        $cobro = Cobro::where("visto", 0)
            ->where("id", "!=", $id)
            ->orderBy("id", "asc")->get()
            ->first();

        if ($cobro) {
            return response()->JSON([
                "sw" => true,
                "cobro" => $cobro->load(["ingreso_salida.espacio"])
            ]);
        }
        return response()->JSON([
            "sw" => false
        ]);
    }

    public function guarda_visto(Cobro $cobro)
    {
        $cobro->visto = 1;
        $cobro->save();
        return response()->JSON([
            "sw" => true,
            "cobro" => $cobro->load(["ingreso_salida.espacio"])
        ]);
    }
}
