@extends('template')

@section('title', 'Editar Repuesto')

@push('css')
<style>
    .edit-container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-submit {
        background-color: #4e73df;
        color: white;
        border: none;
    }

    .btn-submit:hover {
        background-color: #2e59d9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Repuesto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('repuestos.index') }}">Repuestos</a></li>
        <li class="breadcrumb-item active">Editar Repuesto</li>
    </ol>

    <div class="edit-container">
        <form action="{{ route('repuestos.update', $repuesto->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Número de Parte -->
                <div class="col-md-6 mb-3">
                    <label for="nro_parte">Número de Parte</label>
                    <input type="text" name="nro_parte" id="nro_parte" class="form-control" value="{{ $repuesto->nro_parte }}" maxlength="50">
                </div>
                <!-- Número de Serie -->
                <div class="col-md-6 mb-3">
                    <label for="nro_serie">Número de Serie</label>
                    <input type="text" name="nro_serie" id="nro_serie" class="form-control" value="{{ $repuesto->nro_serie }}" maxlength="50">
                </div>
            </div>
            <div class="row">
                <!-- Descripción -->
                <div class="col-md-6 mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" maxlength="200" required>{{ $repuesto->descripcion }}</textarea>
                </div>
                <!-- Observaciones -->
                <div class="col-md-6 mb-3">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" maxlength="200">{{ $repuesto->observaciones }}</textarea>
                </div>
            </div>
            <div class="row">
                <!-- Costo -->
                <div class="col-md-6 mb-3">
                    <label for="costo">Costo</label>
                    <input type="number" name="costo" id="costo" class="form-control" step="0.01" value="{{ $repuesto->costo }}">
                </div>
                <!-- Estado -->
                <div class="col-md-6 mb-3">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="No Instalado" {{ $repuesto->estado == 'No Instalado' ? 'selected' : '' }}>No Instalado</option>
                        <option value="Instalado" {{ $repuesto->estado == 'Instalado' ? 'selected' : '' }}>Instalado</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Equipo -->
                <div class="col-md-6 mb-3">
                    <label for="equipo_id">Equipo</label>
                    <select name="equipo_id" id="equipo_id" class="form-control">
                        <option value="">Seleccione un equipo (opcional)</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}" {{ $repuesto->equipo_id == $equipo->id ? 'selected' : '' }}>{{ $equipo->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Local -->
                <div class="col-md-6 mb-3">
                    <label for="local_id">Local</label>
                    <select name="local_id" id="local_id" class="form-control">
                        <option value="">Seleccione un local (opcional)</option>
                        @foreach($locals as $local)
                            <option value="{{ $local->id }}" {{ $repuesto->local_id == $local->id ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Empresa -->
                <div class="col-md-6 mb-3">
                    <label for="empresa_id">Empresa</label>
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        <option value="">Seleccione una empresa (opcional)</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ $repuesto->empresa_id == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Componente -->
                <div class="col-md-6 mb-3">
                    <label for="componente_id">Componente</label>
                    <select name="componente_id" id="componente_id" class="form-control">
                        <option value="">Seleccione un componente (opcional)</option>
                        @foreach($componentes as $componente)
                            <option value="{{ $componente->id }}" {{ $repuesto->componente_id == $componente->id ? 'selected' : '' }}>{{ $componente->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Subcomponente -->
                <div class="col-md-6 mb-3">
                    <label for="subcomponente_id">Subcomponente</label>
                    <select name="subcomponente_id" id="subcomponente_id" class="form-control">
                        <option value="">Seleccione un subcomponente (opcional)</option>
                        @foreach($subcomponentes as $subcomponente)
                            <option value="{{ $subcomponente->id }}" {{ $repuesto->subcomponente_id == $subcomponente->id ? 'selected' : '' }}>{{ $subcomponente->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-submit">Actualizar Repuesto</button>
                <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
