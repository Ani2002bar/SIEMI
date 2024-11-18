@extends('template')

@section('title', 'Detalles del Componente')

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
    <h1 class="mt-4 text-center">Detalles del Componente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('componentes.index') }}">Componentes</a></li>
        <li class="breadcrumb-item active">Detalles del Componente</li>
    </ol>

    <div class="detail-container">
        <div class="detail-info">
            <h1>{{ $componente->descripcion }}</h1>

            <div class="detail-item">
                <label>Descripción:</label>
                <p>{{ $componente->descripcion }}</p>
            </div>

            <div class="detail-item">
                <label>Modelo:</label>
                <p>{{ $componente->modelo }}</p>
            </div>

            <div class="detail-item">
                <label>Número de Serie:</label>
                <p>{{ $componente->nro_serie }}</p>
            </div>

            <div class="detail-item">
                <label>Equipo Asociado:</label>
                <p>{{ $componente->equipo->descripcion ?? 'Sin equipo asociado' }}</p>
            </div>
        </div>
    </div>

    <div class="buttons-container">
        <a href="{{ route('componentes.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('componentes.edit', $componente->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
