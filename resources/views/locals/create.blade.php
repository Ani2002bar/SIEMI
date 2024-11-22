@extends('template')

@section('title', 'Crear Local')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item.active {
        background-color: #007bff;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Local</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locals.index') }}">Locales</a></li>
        <li class="breadcrumb-item active">Crear Local</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('locals.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre del Local -->
                    <div class="col-md-6">
                        <label for="nombre_local" class="form-label">Nombre del Local:</label>
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control" value="{{ old('nombre_local') }}" required>
                        @error('nombre_local')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
                        @error('direccion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Departamentos -->
                    <div class="col-md-6">
                        <label class="form-label">Departamentos:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#departamentosModal">
                            Agregar Departamentos
                        </button>
                        <!-- Mostrar los departamentos seleccionados temporalmente -->
                        <ul class="list-group mt-2" id="departamentosTemporales">
                            <!-- Los departamentos creados aparecerán aquí -->
                        </ul>
                    </div>

                    <!-- Campo oculto para enviar los departamentos -->
                    <input type="hidden" name="departamentos" id="departamentos">
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('locals.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@include('locals.departamentosModal')

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let departamentos = [];

    function agregarDepartamento() {
        const nombre = document.getElementById('nuevo_departamento_nombre').value;
        const descripcion = document.getElementById('nuevo_departamento_descripcion').value;

        if (nombre.trim() === '') {
            alert('El nombre del departamento es obligatorio.');
            return;
        }

        const nuevoDepartamento = { nombre, descripcion };
        departamentos.push(nuevoDepartamento);

        actualizarListadoTemporal();
        document.getElementById('nuevoDepartamentoForm').reset();
    }

    function actualizarListadoTemporal() {
        const lista = document.getElementById('departamentosTemporales');
        lista.innerHTML = '';

        departamentos.forEach((dep, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.textContent = dep.nombre;

            const btnEliminar = document.createElement('button');
            btnEliminar.className = 'btn btn-sm btn-danger';
            btnEliminar.textContent = 'Eliminar';
            btnEliminar.onclick = () => eliminarDepartamento(index);

            li.appendChild(btnEliminar);
            lista.appendChild(li);
        });

        // Actualizar campo oculto con los departamentos
        document.getElementById('departamentos').value = JSON.stringify(departamentos);
    }

    function eliminarDepartamento(index) {
        departamentos.splice(index, 1);
        actualizarListadoTemporal();
    }
</script>
@endpush
