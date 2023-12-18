<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Espacio;
use App\Models\IngresoSalida;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class ReporteController extends Controller
{
    public function espacios_disponibles(Request $request)
    {
        $filtro =  $request->filtro;
        $espacios = Espacio::all();
        $pdf = PDF::loadView('reportes.espacios_disponibles', compact('espacios'))->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('espacios_disponibles.pdf');
    }
    public function ingresos_salidas(Request $request)
    {
        $filtro =  $request->filtro;
        $ingresos_salidas = IngresoSalida::orderBy("created_at", "asc")->get();
        $pdf = PDF::loadView('reportes.ingresos_salidas', compact('ingresos_salidas'))->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('ingresos_salidas.pdf');
    }

    public function cobros_realizados(Request $request)
    {
        $filtro =  $request->filtro;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $cobros = Cobro::whereBetween("fecha", [$fecha_ini, $fecha_fin])->orderBy("created_at", "asc")->get();
        $pdf = PDF::loadView('reportes.cobros', compact('cobros'))->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('cobros.pdf');
    }
}
