@extends('template')

@section('title', 'Editar Repuesto')

@push('css')
<style>
    .edit-container {
        max-width: 800px;
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
            <div class="form-group mb-3">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" value="{{ $repuesto->codigo }}" maxlength="45" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" maxlength="200" required>{{ $repuesto->descripcion }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" maxlength="200">{{ $repuesto->observaciones }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="costo">Costo</label>
                <input type="number" name="costo" id="costo" class="form-control" step="0.01" value="{{ $repuesto->costo }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="equipo_id">Equipo</label>
                <select name="equipo_id" id="equipo_id" class="form-control" required>
                    <option value="">Seleccione un equipo</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}" {{ $repuesto->equipo_id == $equipo->id ? 'selected' : '' }}>{{ $equipo->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="local_id">Local</label>
                <select name="local_id" id="local_id" class="form-control" required>
                    <option value="">Seleccione un local</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->id }}" {{ $repuesto->local_id == $local->id ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit">Actualizar Repuesto</button>
                <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
