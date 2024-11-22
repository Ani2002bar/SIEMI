@extends('template')

@section('title', 'Detalles del Local')

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
        grid-template-columns: 1fr 1fr;
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

    .table-style th, .table-style td {
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
    <h1 class="mt-4 text-center">Detalles del Local</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locals.index') }}">Locales</a></li>
        <li class="breadcrumb-item active">Detalles del Local</li>
    </ol>

    <div class="detail-container">
        <!-- Primera columna con la imagen y algunos detalles -->
        <div class="detail-info">
            <div class="detail-image-container">
                <img src="{{ $local->imagen ? asset('storage/' . $local->imagen) : asset('img/placeholder.png') }}" alt="Imagen del Local" class="detail-image">
            </div>
            <div class="detail-item">
                <label>Nombre del Local:</label>
                <p>{{ $local->nombre_local }}</p>
            </div>
            <div class="detail-item">
                <label>Dirección:</label>
                <p>{{ $local->direccion }}</p>
            </div>
            <div class="detail-item">
                <label>Teléfono:</label>
                <p>{{ $local->telefono ?? 'No especificado' }}</p>
            </div>
            <div class="detail-item">
                <label>Dirección IP:</label>
                <p>{{ $local->direccion_ip ?? 'No especificado' }}</p>
            </div>
        </div>

        <!-- Segunda columna con el resto de la información -->
        <div class="detail-info">
            <div class="detail-item">
                <label>Fecha de Creación:</label>
                <p>{{ $local->created_at->format('d-m-Y') }}</p>
            </div>
            <div class="detail-item">
                <label>Última Actualización:</label>
                <p>{{ $local->updated_at->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Tablas en secciones separadas para departamentos y subdepartamentos -->
    <div class="table-sections">
        <div class="table-section">
            <div class="table-title-container">
                <div class="table-title">Departamentos</div>
            </div>
            <div class="table-responsive">
                <table class="table-style">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($local->departamentos as $departamento)
                            <tr>
                                <td>{{ $departamento->nombre }}</td>
                                <td>{{ $departamento->descripcion ?? 'No especificada' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-section">
            <div class="table-title-container">
                <div class="table-title">Subdepartamentos</div>
            </div>
            <div class="table-responsive">
                <table class="table-style">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($local->departamentos as $departamento)
                            @foreach ($departamento->subdepartamentos as $subdepartamento)
                                <tr>
                                    <td>{{ $subdepartamento->nombre }}</td>
                                    <td>{{ $departamento->nombre }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de navegación -->
    <div class="buttons-container">
        <a href="{{ route('locals.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('locals.edit', $local->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
