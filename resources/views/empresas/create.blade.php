@extends('template')

@section('title', 'Crear Empresa')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .table th,
        .table td {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        /* Botones con estilo ajustado para que coincidan con locales/create */
        .btn {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 0.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Empresa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active">Crear Empresa</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"
                            required>
                        @error('nombre')
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
                            value="{{ old('direccion_ip') }}" required>
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
                </div>
            </div>

            <!-- Botón para abrir el modal de gestión de locales -->
            <div class="col-md-6">
                <label class="form-label">Locals:</label><br>
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#localsModal">
                    Gestionar Locals
                </button>
                <input type="hidden" name="locals" id="locals" value="[]">
            </div>
    </div>
</div>

<div class="card-footer text-center mt-3">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</div>


<!-- Inclusión del modal -->
@include('empresas.localesModal')
</form>
</div>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const removeButton = document.querySelector('.btn-remove-image');

            imagePreview.src = URL.createObjectURL(event.target.files[0]);
            imagePreview.style.display = 'block';
            removeButton.style.display = 'inline-block';
        }

        function removeImage() {
            const imageInput = document.getElementById('imagen');
            const imagePreview = document.getElementById('image-preview');
            const removeButton = document.querySelector('.btn-remove-image');

            imageInput.value = '';
            imagePreview.style.display = 'none';
            removeButton.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            let localsExistentes = []; // Lista de locals obtenidos del servidor
            let localsVinculados = []; // Lista de locals seleccionados por el usuario

            // Evento al mostrar el modal
            document.getElementById('localsModal').addEventListener('show.bs.modal', () => {
                fetchLocalsExistentes();
            });

            // Función para obtener locals existentes desde el servidor
            function fetchLocalsExistentes() {
                fetch('{{ route("api.locals.get") }}') // Ruta para obtener locals
                    .then(response => response.json())
                    .then(data => {
                        localsExistentes = data; // Guardar locals obtenidos
                        renderLocalsExistentes();
                    })
                    .catch(error => console.error('Error al obtener locals:', error));
            }

            // Renderizar locals existentes en la tabla
            function renderLocalsExistentes() {
                const tbody = document.getElementById('localsExistentes');
                tbody.innerHTML = localsExistentes.map(local => `
                <tr>
                    <td>${local.nombre_local}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="vincularLocal(${local.id})">Vincular</button>
                    </td>
                </tr>
            `).join('');
            }

            // Renderizar locals vinculados en la tabla
            function renderLocalsVinculados() {
                const tbody = document.getElementById('localsVinculados');
                tbody.innerHTML = localsVinculados.map(local => `
                <tr>
                    <td>${local.nombre_local}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="desvincularLocal(${local.id})">Desvincular</button>
                    </td>
                </tr>
            `).join('');
                document.getElementById('locals').value = JSON.stringify(localsVinculados.map(local => local.id));
            }

            // Vincular un local
            window.vincularLocal = function (id) {
                const local = localsExistentes.find(local => local.id === id);
                if (local && !localsVinculados.some(v => v.id === id)) {
                    localsVinculados.push(local);
                    renderLocalsVinculados();
                }
            };

            // Desvincular un local
            window.desvincularLocal = function (id) {
                localsVinculados = localsVinculados.filter(local => local.id !== id);
                renderLocalsVinculados();
            };
        });


    </script>
@endpush