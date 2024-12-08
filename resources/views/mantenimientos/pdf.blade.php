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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #000;
        }

        .header img {
            height: 80px;
        }

        .content {
            flex-grow: 1;
            padding: 10px 0;
        }

        .data-table,
        .repuestos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .data-table th,
        .data-table td,
        .repuestos-table th,
        .repuestos-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin: 5px 0;
            padding: 5px 0;
        }

        .description {
            padding: 10px;
            border: 1px solid #000;
            min-height: 50px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: auto;
            border-top: 1px solid #000;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }

        .footer .signature {
            text-align: center;
            width: 45%;
        }

        .footer .signature p {
            margin: 0;
        }

        .footer .signature .line {
            margin: 10px auto;
            width: 80%;
            height: 1px;
            background-color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%; text-align: center;">
                        <img src="{{ public_path('img/imap_infor_icon.jpg') }}" alt="IMAP Logo">
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <h1 style="margin: 0;">IMAP S.A.</h1>
                        <h4 style="margin: 0;">Diagnóstico por Imágenes</h4>
                        <p style="margin: 0;">Av. Tte. Rojas Silva c/ San Blas, Bo. Pablo Rojas</p>
                        <p style="margin: 0;">Tel: 061 504-569 / 504-573</p>
                        <p style="margin: 0;">Ciudad del Este, Paraguay</p>
                    </td>
                    <td style="width: 30%; text-align: right;">
                        <h4 style="margin: 0;">HOJA DE INTERVENCIÓN TÉCNICA</h4>
                        <p><strong>Número:</strong> {{ $mantenimiento->id }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Datos principales -->
        <div class="content">
            <table class="data-table">
                <tr>
                    <th style="width: 25%;">Local</th>
                    <td style="width: 25%;">{{ $mantenimiento->local->nombre_local }}</td>
                    <th style="width: 25%;">Fecha</th>
                    <td style="width: 25%;">{{ $mantenimiento->fecha }}</td>
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
                    <th>Equipo</th>
                    <td>{{ $mantenimiento->equipo->descripcion }}</td>
                </tr>
            </table>

            <!-- Descripción -->
            <p class="section-title">DESCRIPCIÓN</p>
            <p class="description">{{ $mantenimiento->observaciones }}</p>

            <!-- Repuestos utilizados -->
            <p class="section-title">REPUESTOS UTILIZADOS</p>
            <table class="repuestos-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Item</th>
                        <th style="width: 40%;">Descripción</th>
                        <th style="width: 20%;">Costo</th>
                        <th style="width: 30%;">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mantenimiento->repuestos as $index => $repuesto)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $repuesto->descripcion }}</td>
                            <td>{{ number_format($repuesto->pivot->costo_total, 2) }} PYG</td>
                            <td>{{ $repuesto->observaciones ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">No se utilizaron repuestos en este mantenimiento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; text-align: left;">
                        <p style="margin-bottom: 50px;">Firma Encargado:</p>
                        <div style="width: 80%; height: 1px; background-color: #000;"></div>
                        <p style="margin-top: 10px;">Aclaración:</p>
                    </td>
                    <td style="width: 50%; text-align: left;">
                        <p style="margin-bottom: 50px;">Firma Técnico:</p>
                        <div style="width: 80%; height: 1px; background-color: #000;"></div>
                        <p style="margin-top: 10px;">Aclaración:</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
