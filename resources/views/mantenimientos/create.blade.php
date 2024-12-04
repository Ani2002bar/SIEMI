@extends('template')

@section('title', 'Registrar Mantenimiento')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Registrar Mantenimiento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mantenimientos.index') }}">Mantenimientos</a></li>
        <li class="breadcrumb-item active">Registrar</li>
    </ol>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mantenimientos.store') }}" method="POST">
                @csrf

                <!-- Technician and Local -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tecnico_id" class="form-label">Técnico</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-control">
                            <option value="" selected disabled>Seleccione un técnico</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</option>
                            @endforeach
                        </select>
                        @error('tecnico_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            <option value="" selected disabled>Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                        @error('local_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Equipment and Cost -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="equipo_id" class="form-label">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-control">
                            <option value="" selected disabled>Seleccione un equipo</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}">{{ $equipo->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('equipo_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="costo_reparacion" class="form-label">Costo Reparación</label>
                        <input type="number" step="0.01" name="costo_reparacion" id="costo_reparacion" class="form-control" required>
                        @error('costo_reparacion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Status and Date -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="" selected disabled>Seleccione un estado</option>
                            @foreach($estados as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('estado')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                        @error('fecha')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Observations -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control"></textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit and Cancel -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
