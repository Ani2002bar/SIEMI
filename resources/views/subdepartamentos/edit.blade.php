@extends('template')

@section('title', 'Editar Subdepartamento')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
    .preview-image {
        max-width: 150px;
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Subdepartamento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('subdepartamentos.index') }}">Subdepartamentos</a></li>
        <li class="breadcrumb-item active">Editar Subdepartamento</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('subdepartamentos.update', $subdepartamento->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre del Subdepartamento -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Subdepartamento:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $subdepartamento->nombre) }}" required>
                        @error('nombre')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $subdepartamento->descripcion) }}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Departamento -->
                    <div class="col-md-6">
                        <label for="departamento_id" class="form-label">Departamento:</label>
                        <select name="departamento_id" id="departamento_id" class="form-control" required>
                            <option value="">Seleccione un Departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ $departamento->id == $subdepartamento->departamento_id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('subdepartamentos.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Aquí puedes agregar algún comportamiento si es necesario
    });
</script>
@endpush
