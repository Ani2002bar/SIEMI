<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Equipos</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 20px; /* Ajusta el margen global */
        color: #333;
    }

    .header {
        text-align: center;
        margin: 0;
        padding: 10px 0; /* Espaciado interno para separarlo del borde */
    }

    .header table {
        margin: 0 auto;
        width: 100%;
        border-collapse: collapse;
    }

    .header td {
        vertical-align: middle;
        padding: 5px 10px; /* Espaciado interno entre los elementos */
    }

    .header img {
        height: 80px; /* Tamaño razonable de la imagen */
        margin-right: 20px; /* Separación entre imagen y texto */
    }

    .header p {
        margin: 2px 0; /* Compacta los párrafos sin que se superpongan */
        font-size: 12px;
        line-height: 1.4; /* Espaciado más fluido entre líneas */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px; /* Reduce el margen superior */
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
                <th>#</th>
                <th>Descripción</th>
                <th>Número de Serie</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipos as $index => $equipo)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $equipo->descripcion }}</td>
                    <td>{{ $equipo->nro_serie }}</td>
                    <td>{{ $equipo->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>