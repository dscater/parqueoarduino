<?php

namespace App\Http\Controllers;

use App\Models\Tarifario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarifarioController extends Controller
{
    public $validacion = [
        "tiempo" => "required|numeric|min:1",
        "costo" => "required|numeric|min:1",
    ];

    public $mensajes = [
        'tiempo.required' => 'Este campo es obligatorio',
        'tiempo.numeric' => 'Debes ingresar un valor númerico',
        'tiempo.min' => 'Debes ingresar por lo menos :min',
        'costo.required' => 'Este campo es obligatorio',
        'costo.numeric' => 'Debes ingresar un valor númerico',
        'costo.min' => 'Debes ingresar por lo menos :min',
    ];

    public function index(Request $request)
    {
        $tarifarios = Tarifario::all();
        return response()->JSON(['tarifarios' => $tarifarios, 'total' => count($tarifarios)], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Tarifario
            $nuevo_tarifario = Tarifario::create(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'tarifario' => $nuevo_tarifario,
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

    public function update(Request $request, Tarifario $tarifario)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $tarifario->update(array_map('mb_strtoupper', $request->all()));
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'tarifario' => $tarifario,
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

    public function show(Tarifario $tarifario)
    {
        return response()->JSON([
            'sw' => true,
            'tarifario' => $tarifario
        ], 200);
    }
    public function destroy(Tarifario $tarifario)
    {
        DB::beginTransaction();
        try {
            $tarifario->delete();
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
