@extends('template')

@section('title', 'Detalles del Mantenimiento')

@push('css')
    <style>
        .detail-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .detail-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .detail-info h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 10px;
        }

        .detail-item label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .detail-item p {
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            color: #555;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Detalles del Mantenimiento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mantenimientos.index') }}">Mantenimientos</a></li>
        <li class="breadcrumb-item active">Detalles del Mantenimiento</li>
    </ol>

    <div class="detail-container">

        <div class="detail-info">
            <h1>Mantenimiento #{{ $mantenimiento->id }}</h1>

            <div class="detail-item">
                <label>Técnico:</label>
                <p>{{ $mantenimiento->tecnico->nombre }} {{ $mantenimiento->tecnico->apellido }}</p>
            </div>

            <div class="detail-item">
                <label>Equipo:</label>
                <p>{{ $mantenimiento->equipo->descripcion }}</p>
            </div>

            <div class="detail-item">
                <label>Local:</label>
                <p>{{ $mantenimiento->local->nombre_local }}</p>
            </div>

            <div class="detail-item">
                <label>Costo de Reparación:</label>
                <p>{{ $mantenimiento->costo_reparacion }} PYG</p>
            </div>

            <div class="detail-item">
                <label>Estado:</label>
                <p>{{ $mantenimiento->estado }}</p>
            </div>

            <div class="detail-item">
                <label>Fecha:</label>
                <p>{{ $mantenimiento->fecha }}</p>
            </div>

            <div class="detail-item">
                <label>Observaciones:</label>
                <p>{{ $mantenimiento->observaciones }}</p>
            </div>
            <div class="detail-item">
                <a href="{{ route('mantenimientos.pdf', $mantenimiento->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> Descargar PDF</a>
            </div>
        </div>
    </div>

    <!-- Botones de navegación -->
    <div class="buttons-container">
        <a href="{{ route('mantenimientos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('mantenimientos.edit', $mantenimiento->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection