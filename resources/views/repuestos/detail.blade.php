@extends('template')

@section('title', 'Detalles del Repuesto')

@push('css')
<style>
    .detail-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    }
    .detail-info h1 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 20px;
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
    <h1 class="mt-4 text-center">Detalles del Repuesto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('repuestos.index') }}">Repuestos</a></li>
        <li class="breadcrumb-item active">Detalles del Repuesto</li>
    </ol>

    <div class="detail-container">
        <div class="detail-info">
            <h1>{{ $repuesto->descripcion }}</h1>

            <div class="detail-item">
                <label>Código:</label>
                <p>{{ $repuesto->codigo }}</p>
            </div>

            <div class="detail-item">
                <label>Descripción:</label>
                <p>{{ $repuesto->descripcion }}</p>
            </div>

            <div class="detail-item">
                <label>Observaciones:</label>
                <p>{{ $repuesto->observaciones ?? 'N/A' }}</p>
            </div>

            <div class="detail-item">
                <label>Costo:</label>
                <p>{{ number_format($repuesto->costo, 2) }}</p>
            </div>

            <div class="detail-item">
                <label>Equipo Asociado:</label>
                <p>{{ $repuesto->equipo ? $repuesto->equipo->descripcion : 'N/A' }}</p>
            </div>

            <div class="detail-item">
                <label>Local Asociado:</label>
                <p>{{ $repuesto->local ? $repuesto->local->nombre_local : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="buttons-container">
        <a href="{{ route('repuestos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('repuestos.edit', $repuesto->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
