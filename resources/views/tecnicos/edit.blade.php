@extends('template')

@section('title', 'Editar Técnico')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Editar Técnico</h1>
    <form action="{{ route('tecnicos.update', $tecnico->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $tecnico->nombre }}" required>
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control" value="{{ $tecnico->apellido }}" required>
            @error('apellido') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" class="form-control" value="{{ $tecnico->correo }}" required>
            @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $tecnico->telefono }}" required>
            @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
