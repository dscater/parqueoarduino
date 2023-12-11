<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Espacio;
use App\Models\IngresoSalida;
use App\Models\Tarifario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IngresoSalidaController extends Controller
{
    public function index(Request $request)
    {
        $ingreso_salidas = IngresoSalida::with(["espacio"])->orderBy("id", "desc")->get();
        return response()->JSON(['ingreso_salidas' => $ingreso_salidas, 'total' => count($ingreso_salidas)], 200);
    }

    public function registra_datos(Request $request)
    {
        $datos = $request["datos"];
        $fecha = date("Y-m-d");
        $hora = date("H:i");
        DB::beginTransaction();
        try {
            // separar informacion
            $nro_espacio = 0;
            if (stripos($datos, "LIBRE") !== false) {
                $nro_espacio = (int)substr($datos, 5, 1);
                $espacio = Espacio::where("nro_espacio", $nro_espacio)->get()->first();
                // REGISTRAR SALIDA
                // verificar ultimo ingreso del espacio
                // si tiene la fecha y hora de salida llenados no hacer nada
                $ultimo_ingreso_salida = IngresoSalida::where("espacio_id", $espacio->id)->orderBy("id", "desc")->get()->first();
                if (!$ultimo_ingreso_salida->fecha_salida && !$ultimo_ingreso_salida->hora_salida) {
                    // registrar cobro
                    $fecha_hora_ingreso = $ultimo_ingreso_salida->fecha_ingreso . ' ' . $ultimo_ingreso_salida->hora_ingreso;
                    $fecha_hora_salida = $fecha . ' ' . $hora;
                    $tiempo_minutos = self::calcularDiferenciaEnMinutos($fecha_hora_ingreso, $fecha_hora_salida);
                    $tarifario = Tarifario::where("tiempo", ">=", $tiempo_minutos)->orderBy("tiempo", "asc")->get()->first();
                    if (!$tarifario) {
                        // si no encuentra obtener el de mayor tiempo
                        $tarifario = Tarifario::orderBy("tiempo", "desc")->get()->first();
                    }
                    $ultimo_ingreso_salida->cobro()->create([
                        "tiempo" => $tiempo_minutos,
                        "costo" => $tarifario->costo,
                        "fecha" => $fecha,
                        "hora" => $hora,
                        "visto" => 0,
                    ]);
                    $ultimo_ingreso_salida->tiempo = $tiempo_minutos;
                    $ultimo_ingreso_salida->fecha_salida = $fecha;
                    $ultimo_ingreso_salida->hora_salida = $hora;
                    $ultimo_ingreso_salida->save();
                    $espacio->estado = "LIBRE";
                    $espacio->save();
                }
            } else {
                // REGISTRAR NUEVO INGRESO
                $nro_espacio = (int)substr($datos, 7, 1);
                $espacio = Espacio::where("nro_espacio", $nro_espacio)->get()->first();
                $ultimo_ingreso_salida = IngresoSalida::where("espacio_id", $espacio->id)->orderBy("id", "desc")->get()->first();
                // en este caso ocupar el lugar siempre y cuando el ultimo registro ya este con todos los registros
                if (!$ultimo_ingreso_salida || $ultimo_ingreso_salida->fecha_salida && $ultimo_ingreso_salida->hora_salida) {
                    IngresoSalida::create([
                        "espacio_id" => $espacio->id,
                        "fecha_ingreso" => $fecha,
                        "hora_ingreso" => $hora,
                    ]);
                    $espacio->estado = "OCUPADO";
                    $espacio->save();
                }
            }

            if ($nro_espacio != 0) {
                DB::commit();
                return response()->JSON([
                    "sw" => true,
                ], 200);
            }

            throw new Exception("No se pudo registrar, intente mas tarde");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                "sw" => true,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public static function calcularDiferenciaEnMinutos($fecha1, $fecha2)
    {
        // Convierte las fechas a timestamps
        $timestamp1 = strtotime($fecha1);
        $timestamp2 = strtotime($fecha2);

        // Calcula la diferencia en minutos
        $diferencia_en_segundos = abs($timestamp2 - $timestamp1);
        $diferencia_en_minutos = $diferencia_en_segundos / 60;

        return $diferencia_en_minutos;
    }
}
