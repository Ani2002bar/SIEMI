@extends('template')

@section('title', 'Crear Departamento')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Departamento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('departamentos.index') }}">Departamentos</a></li>
        <li class="breadcrumb-item active">Crear Departamento</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('departamentos.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre del Departamento -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Departamento:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        @error('nombre')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Descripción del Departamento -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Selección del Local -->
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local:</label>
                        <select name="local_id" id="local_id" class="form-control" required>
                            <option value="">Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                        @error('local_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
