@extends('template')

@section('title', 'Detalles del Repuesto')

@push('css')
<style>
    .detail-container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    }

    .detail-item label {
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .detail-item p {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #e0e0e0;
        color: #555;
    }

    .btn-container {
        text-align: center;
        margin-top: 30px;
    }

    .btn-container .btn {
        margin: 0 10px;
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
        <div class="row">
            <!-- Descripción -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="descripcion">Descripción:</label>
                <p>{{ $repuesto->descripcion }}</p>
            </div>
            
            <!-- Número de Serie -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="nro_serie">Número de Serie:</label>
                <p>{{ $repuesto->nro_serie ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="row">
            <!-- Número de Parte -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="nro_parte">Número de Parte:</label>
                <p>{{ $repuesto->nro_parte ?? 'N/A' }}</p>
            </div>
            
            <!-- Observaciones -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="observaciones">Observaciones:</label>
                <p>{{ $repuesto->observaciones ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="row">
            <!-- Costo -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="costo">Costo:</label>
                <p>{{ number_format($repuesto->costo, 2) }}</p>
            </div>
            <!-- Estado -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="estado">Estado:</label>
                <p>{{ $repuesto->estado }}</p>
            </div>
        </div>
        <div class="row">
            <!-- Equipo Asociado -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="equipo">Equipo Asociado:</label>
                <p>{{ $repuesto->equipo ? $repuesto->equipo->descripcion : 'N/A' }}</p>
            </div>
            <!-- Local Asociado -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="local">Local Asociado:</label>
                <p>{{ $repuesto->local ? $repuesto->local->nombre_local : 'N/A' }}</p>
            </div>
        </div>
        <div class="row">
            <!-- Empresa Asociada -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="empresa">Empresa Asociada:</label>
                <p>{{ $repuesto->empresa ? $repuesto->empresa->nombre : 'N/A' }}</p>
            </div>
            <!-- Componente Asociado -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="componente">Componente Asociado:</label>
                <p>{{ $repuesto->componente ? $repuesto->componente->descripcion : 'N/A' }}</p>
            </div>
        </div>
        <div class="row">
            <!-- Subcomponente Asociado -->
            <div class="col-md-6 mb-3 detail-item">
                <label for="subcomponente">Subcomponente Asociado:</label>
                <p>{{ $repuesto->subcomponente ? $repuesto->subcomponente->descripcion : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="btn-container">
        <a href="{{ route('repuestos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('repuestos.edit', $repuesto->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
