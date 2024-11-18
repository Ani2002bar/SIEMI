@extends('template')

@section('title', 'Crear Repuesto')

@push('css')
<style>
    .create-container {
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
    <h1 class="mt-4 text-center">Crear Nuevo Repuesto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('repuestos.index') }}">Repuestos</a></li>
        <li class="breadcrumb-item active">Crear Nuevo Repuesto</li>
    </ol>

    <div class="create-container">
        <form action="{{ route('repuestos.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" maxlength="45" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" maxlength="200" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" maxlength="200"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="costo">Costo</label>
                <input type="number" name="costo" id="costo" class="form-control" step="0.01" required>
            </div>
            <div class="form-group mb-3">
                <label for="equipo_id">Equipo</label>
                <select name="equipo_id" id="equipo_id" class="form-control" required>
                    <option value="">Seleccione un equipo</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}">{{ $equipo->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="local_id">Local</label>
                <select name="local_id" id="local_id" class="form-control" required>
                    <option value="">Seleccione un local</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit">Guardar Repuesto</button>
                <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
