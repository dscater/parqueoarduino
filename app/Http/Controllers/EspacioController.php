<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspacioController extends Controller
{
    public $validacion = [
        "nombre" => "required|min:1",
        "piso_id" => "required",
    ];

    public $mensajes = [
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingresar por lo menos :min caracter',
        'piso_id.required' => 'Este campo es obligatorio',
        'nro_espacio.required' => 'Debes ingresar el nro. del espacio',
        'nro_espacio.unique' => 'Ya existe un espacio con ese nro. asignado',
    ];

    public function index(Request $request)
    {
        $espacios = Espacio::select("espacios.*")
            ->with(["piso"])
            ->join("pisos", "pisos.id", "=", "espacios.piso_id")
            ->orderBy("pisos.nombre", "asc")
            ->get();
        return response()->JSON(['espacios' => $espacios, 'total' => count($espacios)], 200);
    }

    public function store(Request $request)
    {
        $this->validacion["nro_espacio"] = "required|numeric|unique:espacios,nro_espacio";
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $request["estado"] = "LIBRE";
            // crear el Espacio
            $nuevo_espacio = Espacio::create(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'espacio' => $nuevo_espacio,
                'msj' => 'El registro se realizó de forma correcta',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Espacio $espacio)
    {
        $this->validacion["nro_espacio"] = "required|numeric|unique:espacios,nro_espacio," . $espacio->id;
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $espacio->update(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'espacio' => $espacio,
                'msj' => 'El registro se actualizó de forma correcta'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Espacio $espacio)
    {
        return response()->JSON([
            'sw' => true,
            'espacio' => $espacio
        ], 200);
    }
    public function destroy(Espacio $espacio)
    {
        DB::beginTransaction();
        try {
            $espacio->delete();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
