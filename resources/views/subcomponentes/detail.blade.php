@extends('template')

@section('title', 'Detalles del Subcomponente')

@push('css')
    <style>
        .detail-container {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .detail-container h1 {
            font-size: 1.8em;
            color: #333;
            text-align: center;
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
    <h1 class="mt-4 text-center">Detalles del Subcomponente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('subcomponentes.index') }}">Subcomponentes</a></li>
        <li class="breadcrumb-item active">Detalles del Subcomponente</li>
    </ol>

    <div class="detail-container">
        <h1>{{ $subcomponente->descripcion }}</h1>

        <div class="detail-item">
            <label>Descripción:</label>
            <p>{{ $subcomponente->descripcion }}</p>
        </div>

        <div class="detail-item">
            <label>Modelo:</label>
            <p>{{ $subcomponente->modelo }}</p>
        </div>

        <div class="detail-item">
            <label>Número de Serie:</label>
            <p>{{ $subcomponente->nro_serie }}</p>
        </div>

        <div class="detail-item">
            <label>Componente Asociado:</label>
            <p>{{ $subcomponente->componente->descripcion }}</p>
        </div>
    </div>

    <div class="buttons-container">
        <a href="{{ route('subcomponentes.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('subcomponentes.edit', $subcomponente->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
