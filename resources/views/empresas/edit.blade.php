@extends('template')

@section('title', 'Editar Empresa')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .card-header {
            font-weight: bold;
            text-align: center;
        }

        .table-responsive {
            max-height: 300px;
            overflow-y: auto;
        }

        .btn {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Empresa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active">Editar Empresa</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $empresa->nombre) }}" required>
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                            value="{{ old('direccion', $empresa->direccion) }}" required>
                        @error('direccion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control"
                            value="{{ old('direccion_ip', $empresa->direccion_ip) }}" required>
                        @error('direccion_ip')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control"
                            value="{{ old('telefono', $empresa->telefono) }}">
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
                                src="{{ $empresa->imagen ? asset('storage/' . $empresa->imagen) : asset('img/placeholder.png') }}"
                                alt="Vista previa de la imagen" class="preview-image">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image"
                                onclick="removeImage()">Eliminar Imagen</button>
                        </div>
                        <input type="hidden" name="delete_image" id="delete_image" value="0">
                    </div>

                    <!-- Gestión de Locals -->
                    <div class="col-md-12">
                        <label class="form-label">Locals:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#localesModal">
                            Gestionar Locals
                        </button>
                        <input type="hidden" id="localsVinculadosInput" value="{{ json_encode($vinculados) }}">
                        <input type="hidden" name="locals" id="locals">
                    </div>
                </div>
            </div>
            <div class="card-footer text-center mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Locals -->
<div class="modal fade" id="localesModal" tabindex="-1" aria-labelledby="localesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="localesModalLabel">Gestionar Locales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Locales Existentes</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="localsExistentes"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Locales Vinculados</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="localsVinculados"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
    let localsExistentes = @json($locals);
    let localsVinculados = @json($vinculados);

    renderLocalsExistentes(localsExistentes);
    renderLocalsVinculados(localsVinculados);

    document.getElementById('localesModal').addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-vincular')) {
            const id = parseInt(e.target.dataset.id);
            const local = localsExistentes.find(l => l.id === id);
            if (local && !localsVinculados.some(l => l.id === id)) {
                localsVinculados.push(local); // Add local to linked list
                renderLocalsVinculados(localsVinculados);
                updateHiddenField(localsVinculados);
            }
        } else if (e.target.classList.contains('btn-desvincular')) {
            const id = parseInt(e.target.dataset.id);
            localsVinculados = localsVinculados.filter(l => l.id !== id); // Remove local from linked list
            renderLocalsVinculados(localsVinculados);
            updateHiddenField(localsVinculados);
        }
    });

    // Update hidden input before form submission
    function updateHiddenField(locals) {
        document.getElementById('locals').value = JSON.stringify(locals.map(l => l.id));
    }

    // Initial setup for the hidden field
    updateHiddenField(localsVinculados);
});

function renderLocalsExistentes(locals) {
    const tbody = document.getElementById('localsExistentes');
    tbody.innerHTML = locals.map(local => `
        <tr>
            <td>${local.nombre_local}</td>
            <td><button class="btn btn-info btn-sm btn-vincular" data-id="${local.id}">Vincular</button></td>
        </tr>
    `).join('');
}

function renderLocalsVinculados(locals) {
    const tbody = document.getElementById('localsVinculados');
    tbody.innerHTML = locals.map(local => `
        <tr>
            <td>${local.nombre_local}</td>
            <td><button class="btn btn-danger btn-sm btn-desvincular" data-id="${local.id}">Desvincular</button></td>
        </tr>
    `).join('');
}


function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    const removeBtn = document.querySelector('.btn-remove-image');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
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
    input.value = '';
    preview.src = '{{ asset("img/placeholder.png") }}';
    preview.style.display = 'block';
    removeBtn.style.display = 'inline-block';
    document.getElementById('delete_image').value = 1;
}

    </script>
@endpush
