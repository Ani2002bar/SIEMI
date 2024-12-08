@extends('template')

@section('title', 'Detalles del Equipo')

@push('css')
    <style>
        .detail-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .detail-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            border-radius: 10px;
            width: 100%;
            aspect-ratio: 1;
            overflow: hidden;
            padding: 10px;
        }

        .detail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .detail-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .detail-item label {
            font-weight: bold;
            color: #333;
            font-size: 0.95em;
            margin-bottom: 5px;
        }

        .detail-item p {
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            color: #555;
            margin: 0;
            font-size: 0.9em;
        }

        .table-sections {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .table-section {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 15px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .table-title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .table-title {
            font-weight: bold;
            color: #4e73df;
            font-size: 1em;
        }

        .search-bar {
            width: 50%;
        }

        .search-bar input {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

        .table-responsive {
            max-height: 200px;
            overflow-y: auto;
        }

        .table-style {
            width: 100%;
            background-color: white;
            border-radius: 5px;
        }

        .table-style th,
        .table-style td {
            padding: 8px;
            text-align: left;
            border: 1px solid #e3e6f0;
            font-size: 0.85em;
        }

        .table-style th {
            background-color: #f8f9fc;
            color: #858796;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .buttons-container {
            grid-column: span 2;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Detalles del Equipo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item active">Detalles del Equipo</li>
    </ol>

    <div class="detail-container">
        <!-- Primera columna con la imagen y algunos detalles -->
        <div class="detail-info">
            <div class="detail-image-container">
                <img src="{{ $equipo->imagen ? asset($equipo->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}"
                    alt="Imagen del Equipo" class="detail-image">

            </div>
            <div class="detail-item">
                <label>Descripción:</label>
                <p>{{ $equipo->descripcion }}</p>
            </div>
            <div class="detail-item">
                <label>Modelo:</label>
                <p>{{ $equipo->modelo }}</p>
            </div>
            <div class="detail-item">
                <label>Marca:</label>
                <p>{{ $equipo->marca }}</p>
            </div>

            <div class="detail-item">
                <label>Estado:</label>
                <p>{{ $equipo->estado }}</p>
            </div>

        </div>

        <!-- Segunda columna con el resto de la información -->
        <div class="detail-info">
            <div class="detail-item">
                <label>Modalidad:</label>
                <p>{{ $equipo->modalidad->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div class="detail-item">
                <label>Número de Serie:</label>
                <p>{{ $equipo->nro_serie }}</p>
            </div>
            <div class="detail-item">
                <label>Año de Fabricación:</label>
                <p>{{ $equipo->anio_fabricacion }}</p>
            </div>
            <div class="detail-item">
                <label>Fecha de Instalación:</label>
                <p>{{ $equipo->fecha_instalacion }}</p>
            </div>
            <div class="detail-item">
                <label>Empresa:</label>
                <p>{{ $equipo->empresa->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div class="detail-item">
                <label>Local:</label>
                <p>{{ $equipo->local->nombre_local ?? 'Sin asignar' }}</p>
            </div>
            <div class="detail-item">
                <label>Departamento:</label>
                <p>{{ $equipo->departamento->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div class="detail-item">
                <label>Subdepartamento:</label>
                <p>{{ $equipo->subdepartamento->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div class="detail-item">
                <label>Observaciones:</label>
                <p>{{ $equipo->observaciones ?? 'Ninguna' }}</p>
            </div>
            <div class="detail-item">
                <label>Dirección IP:</label>
                <p>{{ $equipo->direccion_ip ?? 'No especificada' }}</p>
            </div>
        </div>
    </div>

    <!-- Tablas en secciones separadas en 3 columnas cuadradas con campo de búsqueda -->
    <div class="table-sections">
        <div class="table-section">
            <div class="table-title-container">
                <div class="table-title">Repuestos</div>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar..." onkeyup="filterTable(this, 'repuestosTable')">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-style" id="repuestosTable">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($repuestos as $repuesto)
                            <tr>
                                <td>{{ $repuesto->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-section">
            <div class="table-title-container">
                <div class="table-title">Componentes</div>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar..." onkeyup="filterTable(this, 'componentesTable')">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-style" id="componentesTable">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Modelo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($componentes as $componente)
                            <tr>
                                <td>{{ $componente->descripcion }}</td>
                                <td>{{ $componente->modelo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-section">
            <div class="table-title-container">
                <div class="table-title">Subcomponentes</div>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar..." onkeyup="filterTable(this, 'subcomponentesTable')">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-style" id="subcomponentesTable">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Modelo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subcomponentes as $subcomponente)
                            <tr>
                                <td>{{ $subcomponente->descripcion }}</td>
                                <td>{{ $subcomponente->modelo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="buttons-container">
        <a href="{{ route('equipos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>

<script>
    function filterTable(input, tableId) {
        let filter = input.value.toLowerCase();
        let table = document.getElementById(tableId);
        let rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName("td");
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none";
        }
    }
</script>
@endsection