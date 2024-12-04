<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Intervención Técnica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            border: 1px solid #000;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #000;
        }
        .header .company-info {
            text-align: left;
            line-height: 1.4;
            width: 50%;
        }
        .header img {
            height: 60px;
            margin-right: 10px;
        }
        .header .form-title {
            text-align: center;
            width: 50%;
        }
        .header .form-title h4 {
            margin: 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin: 0;
            padding: 5px 0;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 20px;
            padding: 10px 20px;
            border-top: 1px solid #000;
        }
        .footer .signature {
            text-align: center;
            width: 45%;
        }
        .footer .signature p {
            margin: 0;
        }
        .footer .signature .line {
            margin: 10px 0;
            display: block;
            width: 80%;
            height: 1px;
            background-color: #000;
            margin-left: auto;
            margin-right: auto;
        }
        .padre{
    border: 1px;
    display: inline-block;
    width: auto;
    margin: 0 20px;
    text-align: justify;
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <!-- Logo -->
            <td style="width: 20%; text-align: center; vertical-align: top;">
                <img src="{{ public_path('img/imap_infor_icon.jpg') }}" alt="IMAP Logo" style="height: 80px;">
            </td>

            <!-- Información de la empresa -->
            <td style="width: 50%; text-align: center; vertical-align: top;">
                <h1 style="margin: 0; font-weight: bold;">IMAP S.A.</h1>
                <h4 style="margin: 0;">Diagnóstico por Imágenes</h4>
                <p style="margin: 0;">Av. Tte. Rojas Silva c/ San Blas, Bo. Pablo Rojas</p>
                <p style="margin: 0;">Tel: 061 504-569 / 504-573</p>
                <p style="margin: 0;">Ciudad del Este, Paraguay</p>
            </td>

            <!-- Título del formulario -->
            <td style="width: 30%; text-align: right; vertical-align: top;">
                <h4 style="margin: 0;">HOJA DE INTERVENCIÓN TÉCNICA</h4>
                <p style="margin: 0;"><strong>Número:</strong> {{ $mantenimiento->id }}</p>
            </td>
        </tr>
    </table>
</div>

        <!-- Datos principales -->
        <table class="data-table">
            <tr>
                <th>Local</th>
                <td>{{ $mantenimiento->local->nombre_local }}</td>
                <th>Fecha</th>
                <td>{{ $mantenimiento->fecha }}</td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>{{ $mantenimiento->local->direccion }}</td>
                <th>Teléfono</th>
                <td>{{ $mantenimiento->local->telefono }}</td>
            </tr>
            <tr>
                <th>Encargado</th>
                <td>{{ $mantenimiento->tecnico->nombre }} {{ $mantenimiento->tecnico->apellido }}</td>
                <th>Código Equipo</th>
                <td>{{ $mantenimiento->equipo->codigo }}</td>
            </tr>
            <tr>
                <th>Equipo</th>
                <td colspan="3">{{ $mantenimiento->equipo->descripcion }}</td>
            </tr>
        </table>

        <!-- Descripción -->
        <p class="section-title">DESCRIPCIÓN</p>
        <p style="padding: 10px;">{{ $mantenimiento->observaciones }}</p>

        

        <!-- Pie de página -->
        <div class="footer">
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 50%; text-align: center; vertical-align: top;">
                <p>Firma Encargado:</p>
                <div style="width: 80%; height: 1px; background-color: #000; margin: 10px auto;"></div>
                <p>Aclaración:</p>
            </td>
            <td style="width: 50%; text-align: center; vertical-align: top;">
                <p>Firma Técnico:</p>
                <div style="width: 80%; height: 1px; background-color: #000; margin: 10px auto;"></div>
                <p>Aclaración:</p>
            </td>
        </tr>
    </table>
</div>
        
    </div>
</body>
</html>
