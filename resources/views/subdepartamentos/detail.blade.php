@extends('template')

@section('title', 'Detalles del Subdepartamento')

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
    .detail-image-container {
        flex: 1;
        max-width: 300px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f0f0f0;
    }
    .detail-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }
    .detail-info {
        flex: 2;
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
    <h1 class="mt-4 text-center">Detalles del Subdepartamento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('subdepartamentos.index') }}">Subdepartamentos</a></li>
        <li class="breadcrumb-item active">Detalles del Subdepartamento</li>
    </ol>

    <div class="detail-container">
        <div class="detail-info">
   

            <div class="detail-item">
                <label>Nombre:</label>
                <p>{{ $subdepartamento->nombre }}</p>
            </div>

            <div class="detail-item">
                <label>Descripción:</label>
                <p>{{ $subdepartamento->descripcion }}</p>
            </div>

            

            <div class="detail-item">
                <label>Departamento Asociado:</label>
                <p>{{ $subdepartamento->departamento->nombre }}</p>
            </div>
        </div>
    </div>

    <div class="buttons-container">
        <a href="{{ route('subdepartamentos.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('subdepartamentos.edit', $subdepartamento->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
