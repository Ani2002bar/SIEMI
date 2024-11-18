@extends('template')

@section('title', 'Editar Componente')

@section('content')
<div class="container mt-4">
    <h2>Editar Componente</h2>
    <form action="{{ route('componentes.update', $componente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $componente->descripcion) }}" required>
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo', $componente->modelo) }}" required>
        </div>

        <div class="mb-3">
            <label for="nro_serie" class="form-label">Número de Serie</label>
            <input type="text" name="nro_serie" id="nro_serie" class="form-control" value="{{ old('nro_serie', $componente->nro_serie) }}">
        </div>

        <div class="mb-3">
            <label for="equipo_id" class="form-label">Equipo Asociado</label>
            <select name="equipo_id" id="equipo_id" class="form-control">
                @foreach ($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ $componente->equipo_id == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('componentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
