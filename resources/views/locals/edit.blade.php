@extends('template')

@section('title', 'Editar Local')

@push('css')
    <style>
        .preview-image {
            max-width: 300px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            display: block;
        }

        .btn-remove-image {
            background-color: #e0e0e0;
            color: #333;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Local</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locals.index') }}">Locales</a></li>
        <li class="breadcrumb-item active">Editar Local</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('locals.update', $local->id) }}" method="post" enctype="multipart/form-data"
            onsubmit="sincronizarDepartamentos()">
            <input type="hidden" id="isEdit" value="1">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre del Local -->
                    <div class="col-md-6">
                        <label for="nombre_local" class="form-label">Nombre del Local:</label>
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control"
                            value="{{ old('nombre_local', $local->nombre_local) }}" required>
                        @error('nombre_local')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                            value="{{ old('direccion', $local->direccion) }}" required>
                        @error('direccion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control"
                            value="{{ old('direccion_ip', $local->direccion_ip) }}">
                        @error('direccion_ip')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control"
                            value="{{ old('telefono', $local->telefono) }}">
                        @error('telefono')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                            onchange="previewImage(event)">
                        @error('imagen')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <div class="mt-3">
                            <img id="image-preview"
                                src="{{ $local->imagen ? asset('storage/' . $local->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}"
                                alt="Vista previa de la imagen" class="preview-image">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image"
                                onclick="removeImage()">Eliminar imagen</button>
                        </div>
                        <input type="hidden" name="delete_image" id="delete_image" value="0">
                    </div>

                    <!-- Departamentos -->
                    <div class="col-md-6">
                        <label class="form-label">Departamentos:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#departamentosModal">
                            Gestionar Departamentos
                        </button>
                        <input type="hidden" name="departamentos" id="departamentos"
                            value="{{ json_encode($local->departamentos) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Empresas:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#empresasModal">
                            Gestionar Empresas
                        </button>
                        <input type="hidden" id="empresasExistentesInput" value="{{ $empresas }}">
                        <input type="hidden" id="empresasVinculadasInput" value="{{ $empresasVinculadas }}">
                        <!-- Campo oculto para sincronizar empresas vinculadas -->
                        <input type="hidden" name="empresas" id="empresas" value="[]">

                    </div>

                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar departamentos desde el backend
        let departamentos = {!! $departamentos !!};

        // Si no hay departamentos, inicializamos como un array vacío
        if (!Array.isArray(departamentos)) {
            departamentos = [];
        }

        // Llama a actualizar la lista al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            actualizarListaDepartamentos();
        });
        //Sincronizar departamentos antes de enviar el formulario
        function sincronizarDepartamentos() {
            document.getElementById('departamentos').value = JSON.stringify(departamentos);
        }

        // Función para mostrar vista previa de imagen
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

        // Función para eliminar la imagen seleccionada
        function removeImage() {
            const input = document.getElementById('imagen');
            const preview = document.getElementById('image-preview');
            const removeBtn = document.querySelector('.btn-remove-image');

            input.value = '';
            preview.src = '{{ asset("img/6QQGqDyu_400x400.jpg") }}';
            preview.style.display = 'block';
            removeBtn.style.display = 'inline-block';
            document.getElementById('delete_image').value = 1;
        }

        // Actualiza el listado de departamentos en la tabla
        function actualizarListaDepartamentos() {
            const tabla = document.getElementById('tablaDepartamentosTemporales');
            tabla.innerHTML = ''; // Limpia la tabla

            departamentos.forEach(dep => {
                const fila = document.createElement('tr');

                // Nombre del departamento
                const celdaNombre = document.createElement('td');
                celdaNombre.textContent = dep.nombre || '(Sin nombre)';
                fila.appendChild(celdaNombre);

                // Acciones (subdepartamentos y eliminar)
                const celdaAcciones = document.createElement('td');

                // Botón para gestionar subdepartamentos
                const btnSubdepartamentos = document.createElement('button');
                btnSubdepartamentos.className = 'btn btn-info btn-sm';
                btnSubdepartamentos.textContent = 'Gestionar Subdepartamentos';
                btnSubdepartamentos.onclick = () => abrirModalSubdepartamentos(dep.id);

                // Botón para eliminar departamento
                const btnEliminar = document.createElement('button');
                btnEliminar.className = 'btn btn-danger btn-sm ms-2';
                btnEliminar.textContent = 'Eliminar';
                btnEliminar.onclick = () => eliminarDepartamento(dep.id);

                celdaAcciones.appendChild(btnSubdepartamentos);
                celdaAcciones.appendChild(btnEliminar);
                fila.appendChild(celdaAcciones);

                tabla.appendChild(fila);
            });

            // Actualiza el input oculto con los datos de los departamentos
            sincronizarDepartamentos();
        }

        // Función para abrir el modal de subdepartamentos
        function abrirModalSubdepartamentos(departamentoId) {
            const departamento = departamentos.find(dep => dep.id === departamentoId);

            if (!departamento) {
                alert('No se encontró el departamento seleccionado.');
                return;
            }

            document.getElementById('subdepartamentosModal').setAttribute('data-departamento-id', departamentoId);
            document.getElementById('subdepartamentosModalLabel').textContent = `Subdepartamentos de: ${departamento.nombre}`;
            actualizarListaSubdepartamentos(departamentoId);

            const modal = new bootstrap.Modal(document.getElementById('subdepartamentosModal'));
            modal.show();
        }

        // Función para actualizar la lista de subdepartamentos
        function actualizarListaSubdepartamentos(departamentoId) {
            const tabla = document.getElementById('tablaSubdepartamentosTemporales');
            tabla.innerHTML = ''; // Limpia la tabla

            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (!departamento) return;

            departamento.subdepartamentos.forEach(subdep => {
                const fila = document.createElement('tr');

                // Nombre del subdepartamento
                const celdaNombre = document.createElement('td');
                celdaNombre.textContent = subdep.nombre || '(Sin nombre)';
                fila.appendChild(celdaNombre);

                // Botón para eliminar subdepartamento
                const celdaAcciones = document.createElement('td');
                const btnEliminar = document.createElement('button');
                btnEliminar.className = 'btn btn-danger btn-sm';
                btnEliminar.innerHTML = '<i class="fas fa-trash"></i>';
                btnEliminar.title = 'Eliminar Subdepartamento';
                btnEliminar.onclick = () => eliminarSubdepartamento(departamentoId, subdep.id);

                celdaAcciones.appendChild(btnEliminar);
                fila.appendChild(celdaAcciones);

                tabla.appendChild(fila);
            });
        }

        // Función para agregar un nuevo departamento
        function agregarDepartamento() {
            const nombre = document.getElementById('nombre_departamento').value.trim();
            const descripcion = document.getElementById('descripcion_departamento').value.trim();

            if (!nombre) {
                alert('El nombre del departamento es obligatorio.');
                return;
            }

            departamentos.push({
                id: Date.now(),
                nombre,
                descripcion,
                subdepartamentos: []
            });

            actualizarListaDepartamentos();
            document.getElementById('nuevoDepartamentoForm').reset();
        }

        // Función para eliminar un departamento
        function eliminarDepartamento(departamentoId) {
            departamentos = departamentos.filter(dep => dep.id !== departamentoId);
            actualizarListaDepartamentos();
        }

        // Función para agregar un nuevo subdepartamento
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
                departamento.subdepartamentos.push({
                    id: Date.now(),
                    nombre,
                    descripcion
                });

                actualizarListaSubdepartamentos(departamentoId);
                sincronizarDepartamentos();
                document.getElementById('nuevoSubdepartamentoForm').reset();
            } else {
                alert('No se encontró el departamento seleccionado.');
            }
        }

        // Función para eliminar un subdepartamento
        function eliminarSubdepartamento(departamentoId, subdepartamentoId) {
            const departamento = departamentos.find(dep => dep.id === departamentoId);
            if (departamento) {
                departamento.subdepartamentos = departamento.subdepartamentos.filter(subdep => subdep.id !== subdepartamentoId);
                actualizarListaSubdepartamentos(departamentoId);
                sincronizarDepartamentos();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    let empresasExistentes = JSON.parse(document.getElementById('empresasExistentesInput').value);
    let empresasVinculadas = JSON.parse(document.getElementById('empresasVinculadasInput').value);

    renderEmpresasExistentes(empresasExistentes);
    renderEmpresasVinculadas(empresasVinculadas);

    // Manejar vínculos entre listas
    document.getElementById('empresasExistentes').addEventListener('click', event => {
        if (event.target.classList.contains('btn-vincular')) {
            const empresaId = parseInt(event.target.dataset.id, 10);
            const empresa = empresasExistentes.find(emp => emp.id === empresaId);
            if (empresa && !empresasVinculadas.some(emp => emp.id === empresaId)) {
                empresasVinculadas.push(empresa);
                renderEmpresasVinculadas(empresasVinculadas);
            }
        }
    });

    document.getElementById('empresasVinculadas').addEventListener('click', event => {
        if (event.target.classList.contains('btn-desvincular')) {
            const empresaId = parseInt(event.target.dataset.id, 10);
            empresasVinculadas = empresasVinculadas.filter(emp => emp.id !== empresaId);
            renderEmpresasVinculadas(empresasVinculadas);
        }
    });

    // Sincronizar empresas vinculadas antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', () => {
        document.getElementById('empresas').value = JSON.stringify(empresasVinculadas);
    });
});

function renderEmpresasExistentes(empresas) {
    const tbody = document.getElementById('empresasExistentes');
    tbody.innerHTML = empresas.map(empresa => `
        <tr>
            <td>${empresa.nombre}</td>
            <td>${empresa.direccion}</td>
            <td><button class="btn btn-info btn-sm btn-vincular" data-id="${empresa.id}">Vincular</button></td>
        </tr>
    `).join('');
}

function renderEmpresasVinculadas(empresas) {
    const tbody = document.getElementById('empresasVinculadas');
    tbody.innerHTML = empresas.map(empresa => `
        <tr>
            <td>${empresa.nombre}</td>
            <td>${empresa.direccion}</td>
            <td><button class="btn btn-danger btn-sm btn-desvincular" data-id="${empresa.id}">Desvincular</button></td>
        </tr>
    `).join('');

    document.getElementById('empresas').value = JSON.stringify(empresas);
}


    </script>



@endpush