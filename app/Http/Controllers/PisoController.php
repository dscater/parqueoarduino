<?php

namespace App\Http\Controllers;

use App\Models\Piso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PisoController extends Controller
{
    public $validacion = [
        "nombre" => "required|min:1",
    ];

    public $mensajes = [
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingresar por lo menos :min caracter',
    ];

    public function index(Request $request)
    {
        $pisos = Piso::all();
        return response()->JSON(['pisos' => $pisos, 'total' => count($pisos)], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Piso
            $nuevo_piso = Piso::create(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'piso' => $nuevo_piso,
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

    public function update(Request $request, Piso $piso)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $piso->update(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'piso' => $piso,
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

    public function show(Piso $piso)
    {
        return response()->JSON([
            'sw' => true,
            'piso' => $piso
        ], 200);
    }
    public function destroy(Piso $piso)
    {
        DB::beginTransaction();
        try {
            $piso->delete();
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
