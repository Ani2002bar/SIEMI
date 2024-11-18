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
        }
        .container {
            width: 100%;
            border: 1px solid #000;
            padding: 10px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 50px;
        }
        .section {
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
        }
        .footer div {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h4>IMAP S.A.<br>Diagnóstico por Imágenes</h4>
                <p>Tel: 061 504-569 / 504-573<br>Ciudad del Este, Paraguay</p>
            </div>
            <div>
                <h4>HOJA DE INTERVENCIÓN TÉCNICA</h4>
                <p>Número: {{ $mantenimiento->id }}</p>
            </div>
        </div>

        <div class="section">
            <p><strong>Local:</strong> {{ $mantenimiento->local->nombre_local }}</p>
            <p><strong>Dirección:</strong> {{ $mantenimiento->local->direccion }}</p>
            <p><strong>Encargado:</strong> {{ $mantenimiento->tecnico->nombre }} {{ $mantenimiento->tecnico->apellido }}</p>
            <p><strong>Equipo:</strong> {{ $mantenimiento->equipo->descripcion }}</p>
            <p><strong>Fecha:</strong> {{ $mantenimiento->fecha }}</p>
            <p><strong>Teléfono:</strong> {{ $mantenimiento->local->telefono }}</p>
            <p><strong>Código Equipo:</strong> {{ $mantenimiento->equipo->codigo }}</p>
        </div>

        <div class="section">
            <h4>DESCRIPCIÓN</h4>
            <p>{{ $mantenimiento->observaciones }}</p>
        </div>

        <div class="section">
            <h4>REPUESTOS</h4>
            <table>
                <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>DESCRIPCIÓN</th>
                        <th>CÓDIGO</th>
                        <th>COSTO</th>
                        <th>OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mantenimiento->repuestos as $index => $repuesto)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $repuesto->descripcion }}</td>
                            <td>{{ $repuesto->codigo }}</td>
                            <td>{{ $repuesto->costo }}</td>
                            <td>{{ $repuesto->observaciones }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div>
                <p>Firma Encargado:</p>
                <p>_________________________</p>
                <p>Aclaración:</p>
            </div>
            <div>
                <p>Firma Técnico:</p>
                <p>_________________________</p>
                <p>Aclaración:</p>
            </div>
        </div>
    </div>
</body>
</html>
