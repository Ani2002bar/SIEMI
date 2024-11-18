@extends('template')

@section('title', 'Añadir Componente')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Añadir Componente</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('componentes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del Componente</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>
            <div class="mb-3">
                <label for="nro_serie" class="form-label">Número de Serie</label>
                <input type="text" class="form-control" id="nro_serie" name="nro_serie" required>
            </div>
            <div class="mb-3">
                <label for="equipo_id" class="form-label">Equipo Asociado</label>
                <select class="form-control" id="equipo_id" name="equipo_id" required>
                    <option value="">Seleccionar Equipo</option>
                    @foreach ($equipos as $equipo)
                        <option value="{{ $equipo->id }}">{{ $equipo->descripcion }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Componente</button>
            <a href="{{ route('componentes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
