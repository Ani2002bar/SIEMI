@extends('template')

@section('title', 'Crear Local')

@push('css')
    <style>
        .preview-image {
            max-width: 300px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            display: none;
        }

        .btn-remove-image {
            display: none;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Local</h1>
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
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control"
                            value="{{ old('nombre_local') }}" required>
                        @error('nombre_local')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                            value="{{ old('direccion') }}" required>
                        @error('direccion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control"
                            value="{{ old('direccion_ip') }}">
                        @error('direccion_ip')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control"
                            value="{{ old('telefono') }}">
                        @error('telefono')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen (Opcional):</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                            onchange="previewImage(event)">
                        @error('imagen')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <div class="mt-3">
                            <img id="image-preview" src="#" alt="Vista previa de la imagen" class="preview-image">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image"
                                onclick="removeImage()">Eliminar imagen</button>
                        </div>
                    </div>

                    <!-- Departamentos -->
                    <div class="col-md-6">
                        <label class="form-label">Departamentos:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#departamentosModal">
                            Gestionar Departamentos
                        </button>
                        <input type="hidden" name="departamentos" id="departamentos">
                    </div>

                    <!-- Empresas -->
                    <div class="col-md-6">
                        <label class="form-label">Empresas:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#empresasModal">
                            Gestionar Empresas
                        </button>
                        <input type="hidden" name="empresas" id="empresas">
                    </div>
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
@include('locals.subdepartamentosModal')
@include('locals.empresasModal')

@endsection

@push('js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview');
            const removeBtn = document.querySelector('.btn-remove-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    removeBtn.style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('imagen');
            const preview = document.getElementById('image-preview');
            const removeBtn = document.querySelector('.btn-remove-image');

            input.value = ''; // Reset file input
            preview.src = '#';
            preview.style.display = 'none';
            removeBtn.style.display = 'none';
        }


        let departamentos = []; // Array para almacenar departamentos y subdepartamentos

        // Función para agregar un departamento
        function agregarDepartamento() {
            const nombre = document.getElementById('nombre_departamento').value.trim();
            const descripcion = document.getElementById('descripcion_departamento').value.trim();

            if (!nombre) {
                alert('El nombre del departamento es obligatorio.');
                return;
            }

            const nuevoDepartamento = {
                id: Date.now(), // ID único para frontend
                nombre,
                descripcion,
                subdepartamentos: [], // Array vacío para subdepartamentos
            };

            departamentos.push(nuevoDepartamento);
            actualizarListaDepartamentos();
            document.getElementById('nuevoDepartamentoForm').reset();
        }

        // Función para actualizar la lista de departamentos
        function actualizarListaDepartamentos() {
            const tabla = document.getElementById('tablaDepartamentosTemporales');
            tabla.innerHTML = '';

            departamentos.forEach(dep => {
                const fila = document.createElement('tr');

                const celdaNombre = document.createElement('td');
                celdaNombre.textContent = dep.nombre;
                fila.appendChild(celdaNombre);

                const celdaAcciones = document.createElement('td');

                // Botón de agregar subdepartamentos
                const btnSubdepartamentos = document.createElement('button');
                btnSubdepartamentos.className = 'btn btn-info btn-sm';
                btnSubdepartamentos.textContent = 'Agregar Subdepartamento';
                btnSubdepartamentos.onclick = () => abrirModalSubdepartamentos(dep.id);

                // Botón de eliminar departamento
                const btnEliminar = document.createElement('button');
                btnEliminar.className = 'btn btn-danger btn-sm ms-2';
                btnEliminar.innerHTML = '<i class="fas fa-trash"></i>'; // Icono de eliminar
                btnEliminar.title = 'Eliminar Departamento';
                btnEliminar.onclick = () => eliminarDepartamento(dep.id);

                celdaAcciones.appendChild(btnSubdepartamentos);
                celdaAcciones.appendChild(btnEliminar);
                fila.appendChild(celdaAcciones);

                tabla.appendChild(fila);
            });

            // Actualizar el input oculto
            document.getElementById('departamentos').value = JSON.stringify(departamentos);
        }

        // Función para abrir el modal de subdepartamentos
        function abrirModalSubdepartamentos(departamentoId) {
            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (!departamento) {
                alert('No se encontró el departamento.');
                return;
            }

            document.getElementById('subdepartamentosModal').setAttribute('data-departamento-id', departamentoId);
            document.getElementById('subdepartamentosModalLabel').textContent = `Subdepartamentos de ${departamento.nombre}`;
            actualizarListaSubdepartamentos(departamentoId);
            $('#subdepartamentosModal').modal('show');
        }

        // Función para agregar un subdepartamento
        function agregarSubdepartamento() {
            const departamentoId = Number(document.getElementById('subdepartamentosModal').getAttribute('data-departamento-id'));
            const nombre = document.getElementById('nombre_subdepartamento').value.trim();
            const descripcion = document.getElementById('descripcion_subdepartamento').value.trim();

            if (!nombre) {
                alert('El nombre del subdepartamento es obligatorio.');
                return;
            }

            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (departamento) {
                const nuevoSubdepartamento = {
                    id: Date.now(), // ID único para frontend
                    nombre,
                    descripcion,
                };

                departamento.subdepartamentos.push(nuevoSubdepartamento);
                actualizarListaSubdepartamentos(departamentoId);
                document.getElementById('nuevoSubdepartamentoForm').reset();

                // Actualizar el input oculto
                document.getElementById('departamentos').value = JSON.stringify(departamentos);
            } else {
                alert('No se encontró el departamento.');
            }
        }

        // Función para actualizar la lista de subdepartamentos
        function actualizarListaSubdepartamentos(departamentoId) {
            const tabla = document.getElementById('tablaSubdepartamentosTemporales');
            tabla.innerHTML = '';

            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (departamento) {
                departamento.subdepartamentos.forEach(subdep => {
                    const fila = document.createElement('tr');

                    const celdaNombre = document.createElement('td');
                    celdaNombre.textContent = subdep.nombre;
                    fila.appendChild(celdaNombre);

                    const celdaAcciones = document.createElement('td');

                    // Botón de eliminar subdepartamento
                    const btnEliminar = document.createElement('button');
                    btnEliminar.className = 'btn btn-danger btn-sm';
                    btnEliminar.innerHTML = '<i class="fas fa-trash"></i>'; // Icono de eliminar
                    btnEliminar.title = 'Eliminar Subdepartamento';
                    btnEliminar.onclick = () => eliminarSubdepartamento(departamentoId, subdep.id);

                    celdaAcciones.appendChild(btnEliminar);
                    fila.appendChild(celdaAcciones);

                    tabla.appendChild(fila);
                });
            }
        }

        // Función para eliminar un departamento
        function eliminarDepartamento(departamentoId) {
            departamentos = departamentos.filter(dep => dep.id !== departamentoId);
            actualizarListaDepartamentos();
        }

        // Función para eliminar un subdepartamento
        function eliminarSubdepartamento(departamentoId, subdepartamentoId) {
            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (departamento) {
                departamento.subdepartamentos = departamento.subdepartamentos.filter(subdep => subdep.id !== subdepartamentoId);
                actualizarListaSubdepartamentos(departamentoId);
                document.getElementById('departamentos').value = JSON.stringify(departamentos);
            }
        }


    </script>
@endpush