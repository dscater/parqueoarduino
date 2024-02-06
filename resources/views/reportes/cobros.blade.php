<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>IngresosSalidasTiempo</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 2cm;
            margin-bottom: 1cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            padding: 3px;
            font-size: 10pt;
            word-wrap: break-word;
        }

        table thead tr th {
            font-size: 9pt;
        }

        table tbody tr td {
            font-size: 8pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            width: 200px;
            height: 90px;
            top: -20px;
            left: -20px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(236, 236, 236)
        }

        tr {
            page-break-inside: avoid !important;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .p_cump {
            color: red;
            font-size: 1.2em;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(202, 202, 202);
        }

        .bg-principal {
            background: #083b7a;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        .bold {
            font-weight: bold
        }
    </style>
</head>

<body>
    <div class="encabezado">
        <div class="logo">
            <img src="{{ asset('imgs/logo.png') }}">
        </div>
        <h4 class="texto">COBROS REALIZADOS</h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>
    <table border="1">
        <thead class="bg-principal">
            <tr>
                <th>FECHA Y HORA</th>
                <th>PISO</th>
                <th>ESPACIO</th>
                <th>TIEMPO (MINUTOS)</th>
                <th>COSTO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
                $total = 0;
            @endphp
            @foreach ($cobros as $value)
                @php
                    $total += $value->costo;
                @endphp
                <tr>
                    <td class="centreado">{{ $value->fecha_ft }}</td>
                    <td class="centreado">{{ $value->ingreso_salida->espacio->piso->nombre }}</td>
                    <td class="centreado">{{ $value->ingreso_salida->espacio->nombre }}</td>
                    <td class="centreado">{{ $value->ingreso_salida->tiempo_t }}</td>
                    <td class="centreado">{{ number_format($value->costo, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="centreado bg-principal bold" colspan="4">TOTAL</td>
                <td class="centreado bg-principal bold">{{ number_format($total, 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
