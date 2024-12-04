@extends('template')

@section('title', 'Detalles de la Empresa')

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

    .table-section {
        margin-top: 30px;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 15px;
        background-color: #ffffff;
    }

    .table-title {
        font-weight: bold;
        color: #4e73df;
        font-size: 1em;
        margin-bottom: 10px;
    }

    .table-style {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
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
    <h1 class="mt-4 text-center">Detalles de la Empresa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active">Detalles de la Empresa</li>
    </ol>

    <div class="detail-container">
        <div class="detail-info">
            <div class="detail-image-container">
                <img src="{{ $empresa->imagen ? asset('storage/' . $empresa->imagen) : asset('img/placeholder.png') }}" alt="Imagen de la Empresa" class="detail-image">
            </div>
        </div>
        <div class="detail-info">
            <div class="detail-item">
                <label>Nombre de la Empresa:</label>
                <p>{{ $empresa->nombre }}</p>
            </div>
            <div class="detail-item">
                <label>Dirección:</label>
                <p>{{ $empresa->direccion }}</p>
            </div>
            <div class="detail-item">
                <label>Teléfono:</label>
                <p>{{ $empresa->telefono ?? 'No especificado' }}</p>
            </div>
            <div class="detail-item">
                <label>Dirección IP:</label>
                <p>{{ $empresa->direccion_ip ?? 'No especificado' }}</p>
            </div>
            <div class="detail-item">
                <label>Última Actualización:</label>
                <p>{{ $empresa->updated_at->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>

    <div class="table-section">
        <div class="table-title">Locales Vinculados</div>
        <table class="table-style">
            <thead>
                <tr>
                    <th>Nombre del Local</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empresa->locals as $local)
                    <tr>
                        <td>{{ $local->nombre_local }}</td>
                        <td>{{ $local->direccion }}</td>
                        <td>{{ $local->telefono ?? 'No especificado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No hay locales vinculados a esta empresa</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="buttons-container">
        <a href="{{ route('empresas.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
