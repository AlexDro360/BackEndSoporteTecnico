<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Trabajo de Mantenimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;
        }
        .header, .footer {
            font-size: 11px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .signature {
            height: 50px;
        }
        .logo-cell {
            width: 100px;
            text-align: center;
            vertical-align: middle;
        }
        .top-table {
            vertical-align: top;
            width: 100%;
        }

        td{
            padding: 5px;
            vertical-align: top;
        }
        .numero_orden{
            text-align: end;
        }
    </style>
</head>
<body>

    {{-- {{dd($respuesta)}} --}}
    <table class="top-table" style="margin-bottom: 20px;">
        <tr>

            <td class="logo-cell" rowspan="3" style="border: 1px solid black; text-align: center; vertical-align: middle;">
                <img src="{{ public_path() . '/images/ito_logo.jpg' }}" width="80" alt="Logo">
            </td>

            <td style="border: 1px solid black; ">
                Formato para Orden de Trabajo de Mantenimiento
            </td>
            <td style="border: 1px solid black; width: 180px">
                Código: TecNM-AD-PO-001-04
            </td>
        </tr>
        <tr>
            <td rowspan="2" style="border: 1px solid black; vertical-align: top;">
                Referencia a la Norma ISO 9001:2015 6.1, 7.1, 7.2, 7.4, 7.5.1, 8.1<br>
                Referencia a la Norma ISO 14001:2015 4.1, 6.1, 8.1, 8.2
            </td>
            <td style="border: 1px solid black; ">
                Revisión: 0
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; ">
                Página 1 de 1
            </td>
        </tr>
    </table>


    <div class="center bold" style="margin-bottom: 10px;">Orden de Trabajo de Mantenimiento</div>
    
    <div class="numero_orden" style="margin-bottom: 10px;">
        <div class="bold" style="text-align: right;">
            Número de orden: {{ str_pad($respuesta->folio, 3, '0', STR_PAD_LEFT) }}
        </div>

    </div>
    

    <table style="margin-bottom: 40px;">
        <tr>
            <td class="bold">Mantenimiento:</td>
            <td class="bold">{{ isset($respuesta->tipoMantenimiento) && $respuesta->tipoMantenimiento->nombre === 'Interno' ? 'X Interno' : 'Externo' }}</td>
            <td class="bold">{{ isset($respuesta->tipoMantenimiento) && $respuesta->tipoMantenimiento->nombre === 'Externo' ? 'X Externo' : 'Interno' }}</td>
        </tr>



        <tr style="border-top: 1px solid black;">
            <td class="bold">Tipo de servicio:</td>
            <td>
                {{ isset($respuesta->tipoServicio) ? $respuesta->tipoServicio->nombre : '' }}
            </td>
            <td></td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <td class="bold">Asignado a:</td>
            <td>
                @if(isset($respuesta->solicitud->personalAtencion) && $respuesta->solicitud->personalAtencion->isNotEmpty())
                    @foreach($respuesta->solicitud->personalAtencion as $persona)
                        {{ $persona->name }} {{ $persona->surnameP }} {{ $persona->surnameM }}<br>
                    @endforeach
                @else
                @endif
            </td>

            <td></td>
        </tr>

    </table>
    
    <table style="margin-bottom: 10px;">
        <tr>
            <td class="bold" >Fecha de realización: {{ $respuesta['fecha'] }}</td>
            <td></td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <td style="height: 100px; vertical-align: top;" colspan="2" class="bold">
                Trabajo Realizado: {{ $respuesta['descripcion'] }}
            </td>
        </tr>
        {{-- {{dd($respuesta)}} --}}
        <tr>
            <td colspan="2" class="bold">Departamento: {{ $respuesta->solicitud->user->departamento->nombre}}</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">Folio I: {{ str_pad($respuesta->folio, 3, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <td class="bold" style="width: 50%;">Verificado y Liberado por: {{ $respuesta['nombreVerifico'] }}</td>
            <td class="bold">Fecha y Firma: {{ $respuesta['fecha'] }}</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <td class="bold" style="width: 50%;">Aprobado por: {{ $respuesta->aprobo->nombreCompleto }}</td>
            <td class="bold">Fecha y Firma: {{ $respuesta['fecha'] }}</td>
        </tr>
    </table>
    
    <div class="footer" style="margin-top: 30px;">
        C.c.p. Departamento de Planeación Programación y Presupuestación<br>
        C.c.p. Área Solicitante.
    </div>

    <div style="display: flex; justify-content: space-between; margin-top: 10px; vertical-align: end; ">
        <div class="footer" style="text-align: left;">
            TecNM-AD-PO-001-04
        </div>
        <div class="footer" style="text-align: right;">
            Rev. 0
        </div>
    </div>
    

</body>
</html>
