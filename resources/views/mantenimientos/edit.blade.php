@extends('template')

@section('title', 'Editar Mantenimiento')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Mantenimiento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mantenimientos.index') }}">Mantenimientos</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mantenimientos.update', $mantenimiento->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tecnico_id" class="form-label">Técnico</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-control">
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ $tecnico->id == $mantenimiento->tecnico_id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local->id == $mantenimiento->local_id ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="equipo_id" class="form-label">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-control">
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" {{ $equipo->id == $mantenimiento->equipo_id ? 'selected' : '' }}>
                                    {{ $equipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="costo_reparacion" class="form-label">Costo Reparación</label>
                        <input type="number" step="0.01" name="costo_reparacion" id="costo_reparacion" class="form-control" value="{{ $mantenimiento->costo_reparacion }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ $mantenimiento->estado }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $mantenimiento->fecha }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control">{{ $mantenimiento->observaciones }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
