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
        }

        .section-header {
            font-weight: bold;
            font-size: 1.5em;
            color: #333;
            margin-bottom: 15px;
        }

        .detail-item label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .detail-item p {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f7f7f7;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .table-repuestos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-repuestos th, .table-repuestos td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .table-repuestos th {
            background-color: #f4f4f4;
            font-weight: bold;
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
        <!-- Información general -->
        <div class="section-header">Información General</div>
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
            <p>{{ number_format($mantenimiento->costo_reparacion, 2) }} PYG</p>
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
            <label>Descripción:</label>
            <p>{{ $mantenimiento->observaciones }}</p>
        </div>

        <!-- Tabla de repuestos -->
        <div class="section-header">Repuestos Utilizados</div>
        <table class="table-repuestos">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Descripción</th>
                    <th>Código</th>
                    <th>Costo</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mantenimiento->repuestos as $index => $repuesto)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $repuesto->descripcion }}</td>
                        <td>{{ $repuesto->nro_parte ?? 'N/A' }}</td>
                        <td>{{ number_format($repuesto->pivot->costo_total, 2) }} PYG</td>
                        <td>{{ $repuesto->observaciones ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No se utilizaron repuestos en este mantenimiento.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Botones de navegación -->
    <div class="buttons-container">
        <a href="{{ route('mantenimientos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('mantenimientos.edit', $mantenimiento->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('mantenimientos.pdf', $mantenimiento->id) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
</div>
@endsection
