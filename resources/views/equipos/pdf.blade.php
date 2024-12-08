<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Equipos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin: 0;
            padding: 10px 0;
        }

        .header table {
            margin: 0 auto;
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: middle;
            padding: 5px 10px;
        }

        .header img {
            height: 80px;
            margin-right: 20px;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead th {
            text-align: left;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            background-color: #f4f4f4;
            border-bottom: 2px solid #ddd;
        }

        table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <!-- Logo -->
                <td style="text-align: center; vertical-align: top;">
                    <img src="{{ public_path('img/imap_infor_icon.jpg') }}" alt="IMAP Logo">
                </td>

                <!-- Información de la empresa -->
                <td style="text-align: center; vertical-align: top;">
                    <p>IMAP S.A.</p>
                    <p>Diagnóstico por Imágenes</p>
                    <p>Av. Tte. Rojas Silva c/ San Blas, Bo. Pablo Rojas</p>
                    <p>Tel: 061 504-569 / 504-573</p>
                    <p>Ciudad del Este, Paraguay</p>
                </td>
            </tr>
        </table>
    </div>

    <h1 style="text-align: center; font-size: 18px; margin-bottom: 20px;">Listado de Equipos</h1>

    <table>
        <thead>
            <tr>
                <th>Ítem</th>
                <th>Descripción</th>
                <th>Número de Serie</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Empresa</th>
                <th>Local</th>
                <th>Modalidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipos as $index => $equipo)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $equipo->descripcion }}</td>
                    <td>{{ $equipo->nro_serie }}</td>
                    <td>{{ $equipo->marca }}</td>
                    <td>{{ $equipo->modelo }}</td>
                    <td>{{ $equipo->empresa->nombre ?? 'N/A' }}</td>
                    <td>{{ $equipo->local->nombre_local ?? 'N/A' }}</td>
                    <td>{{ $equipo->modalidad->nombre ?? 'N/A' }}</td>
                    <td>{{ $equipo->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen de Equipos -->
<div class="summary">
        <p><strong>Cantidad Total de Equipos:</strong> {{ $equipos->count() }}</p>
        <p><strong>Cantidad Total de Equipos Inactivos:</strong> {{ $equipos->where('estado', 'Inactivo')->count() }}</p>
    </div>
</body>

</html>
