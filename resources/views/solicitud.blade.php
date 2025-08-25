<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formato de Solicitud de Mantenimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
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
        .encabezado{
            width: 100%;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="encabezado" style="font-size: 0; font-family:'Times New Roman', Times, serif">
        <div style="display: inline-block; width: 20%; text-align: left; vertical-align: top">
            <img src="{{ public_path() . '/images/Logo-TecNM.jpg' }}" height="60" alt="Logo">
        </div>
        <div style="display: inline-block; text-align:center; width:60%; font-size: 10pt">
            <p class="bold" style="margin-bottom: 0px">TECNOLÓGICO NACIONAL DE MÉXICO</p>
            <P class="bold" style="margin-top: 0px">Instituto Tecnológico de Oaxaca</P>
            <P style="font-size: 11pt">Solicitud de Mantenimiento Correctivo</P>
        </div>
        <div style="display: inline-block; width: 20%; heigth: 100%; text-align: right; vertical-align: top">
            <img src="{{ public_path() . '/images/ito_logo.jpg' }}" height="60" alt="Logo">
        </div>
    </div>
    

<div style="width: 100%; display: block;">
    <div style="margin-left: auto; width: 250px; margin-bottom: 40px; text-align: center; opacity: 0.5; font-family:'Times New Roman', Times, serif">
        REG-7130-03 Rev.02
    </div>
    <div style="margin-left: auto; width: 250px; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse">
            <tr>
                <td>Recursos Materiales y Servicios:</td>
                <td style="border: 1px solid black; width: 20px"></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">Mantenimiento de equipo</td>
                <td  style="border: 1px solid black; width: 20px"></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">Centro de computo</td>
                <td style="border: 1px solid black; width: 20px"></td>
            </tr>
        </table>
    </div>

    <div class="bold" style="width: 250px; margin-left: auto; text-align: center; margin-bottom: 20px">
        Folio: <p style="display: inline; margin-left: 10px">{{$data->user->departamento->abreviatura}}/{{ str_pad($data->folio, 3, '0', STR_PAD_LEFT) }}</p>
    </div>
</div>


    <table style="margin-bottom: 10px;">
        <tr>
            <td style="padding-bottom: 15px; padding-top: 15px">
                <p class="bold" style="display: inline">Área Solicitante:</p> 
                <p style="display: inline; margin-left: 10px">{{ $data->user->departamento->nombre }}</p>
            </td>
        </tr>
    </table>
    
    <table style="margin-bottom: 10px;">
    <tr style="border-top: 1px solid black;">
        <td style="padding-bottom: 15px; padding-top: 15px">
            <p class="bold" style="display: inline;">Nombre y Firma del Solicitante:</p>
            <p style="display: inline; margin-left: 10px">{{ $data->user->name }} {{ $data->user->surnameP }} {{ $data->user->surnameM }}</p>
        </td>
    </tr>
    <tr style="border-top: 1px solid black;">
        <td style="padding-bottom: 15px; padding-top: 15px">
            <p class="bold" style="display: inline;">Fecha de elaboración:</p>
            <p style="display: inline; margin-left: 10px">{{ $data->created_at }}</p>
        </td>
    </tr>
    <tr style="border-top: 1px solid black;">
        <td style="padding-bottom: 15px; padding-top: 15px">
            <p class="bold" style="display: inline;">Descripción del servicio solicitado o falla a reparar:</p>
        </td>
    </tr>
    <tr style="border-top: 1px solid black;">
        <td style="height: 300px">
            <p style="margin: 0;">{{ $data->descripcionUser }}</p>
        </td>
    </tr>
</table>

    
    <div class="footer" style="margin-top: 30px;">
        C.c.p. Departamento de Planeación Programación y Presupuestación<br>
        C.c.p. Área Solicitante.
    </div>

    {{-- <div style="display: flex; justify-content: space-between; margin-top: 10px; vertical-align: end; ">
        <div class="footer" style="text-align: left;">
            TecNM-AD-PO-001-04
        </div>
        <div class="footer" style="text-align: right;">
            Rev. 0
        </div>
    </div> --}}
    

</body>
</html>
