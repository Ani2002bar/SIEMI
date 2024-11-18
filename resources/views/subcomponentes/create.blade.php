@extends('template')

@section('title', 'Crear Subcomponente')

@push('css')
    <style>
        .form-container {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }
        .form-container h1 {
            font-size: 1.8em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group select {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            background-color: #f7f7f7;
        }
        .form-group textarea {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            background-color: #f7f7f7;
            resize: vertical;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            font-size: 1.2em;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .back-button:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Añadir Subcomponente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('subcomponentes.index') }}">Subcomponentes</a></li>
        <li class="breadcrumb-item active">Crear Subcomponente</li>
    </ol>

    <div class="form-container">
        <form action="{{ route('subcomponentes.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion') }}" required>
                @error('descripcion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}">
                @error('modelo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nro_serie">Número de Serie</label>
                <input type="text" name="nro_serie" id="nro_serie" class="form-control" value="{{ old('nro_serie') }}">
                @error('nro_serie')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="componente_id">Componente Asociado</label>
                <select name="componente_id" id="componente_id" class="form-control" required>
                    <option value="">Seleccione un Componente</option>
                    @foreach($componentes as $componente)
                        <option value="{{ $componente->id }}" {{ old('componente_id') == $componente->id ? 'selected' : '' }}>
                            {{ $componente->descripcion }}
                        </option>
                    @endforeach
                </select>
                @error('componente_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-submit mt-3">Guardar Subcomponente</button>
        </form>
    </div>
</div>
@endsection
