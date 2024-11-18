@extends('template')

@section('title', 'Editar Subcomponente')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar Subcomponente</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('subcomponentes.update', $subcomponente->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $subcomponente->nombre }}" required>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $subcomponente->modelo }}" required>
            </div>
            <div class="mb-3">
                <label for="nro_serie" class="form-label">Número de Serie</label>
                <input type="text" class="form-control" id="nro_serie" name="nro_serie" value="{{ $subcomponente->nro_serie }}" required>
            </div>
            <div class="mb-3">
                <label for="componente_id" class="form-label">Componente</label>
                <select class="form-control" id="componente_id" name="componente_id" required>
                    <option value="">Seleccionar Componente</option>
                    @foreach ($componentes as $componente)
                        <option value="{{ $componente->id }}" {{ $subcomponente->componente_id == $componente->id ? 'selected' : '' }}>
                            {{ $componente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('subcomponentes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
