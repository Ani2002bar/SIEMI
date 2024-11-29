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
    <h1 class="mt-4 text-center">Editar Local</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locals.index') }}">Locales</a></li>
        <li class="breadcrumb-item active">Editar Local</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('locals.update', $local->id) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre del Local -->
                    <div class="col-md-6">
                        <label for="nombre_local" class="form-label">Nombre del Local:</label>
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control" value="{{ old('nombre_local', $local->nombre_local) }}" required>
                        @error('nombre_local')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $local->direccion) }}" required>
                        @error('direccion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @error('imagen')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <div class="mt-3">
                            <p>Vista previa de la imagen:</p>
                            <img id="preview" 
                                 src="{{ $local->imagen ? asset('storage/' . $local->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}" 
                                 alt="Imagen del Local" 
                                 class="preview-image">
                            <button type="button" class="btn btn-remove-image" onclick="removeImage()">Eliminar Imagen</button>
                        </div>
                        <input type="hidden" name="delete_image" id="delete_image" value="0">
                    </div>

                    <!-- Departamentos -->
                    <div class="col-md-6">
                        <label class="form-label">Departamentos:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#departamentosModal">
                            Gestionar Departamentos
                        </button>
                        <input type="hidden" name="departamentos" id="departamentos" value="{{ json_encode($local->departamentos) }}">
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

<!-- Modal Departamentos -->
<div class="modal fade" id="departamentosModal" tabindex="-1" aria-labelledby="departamentosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departamentosModalLabel">Gestionar Departamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Subdepartamentos</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-departamentos">
                        @foreach ($local->departamentos as $departamento)
                        <tr>
                            <td>{{ $departamento->nombre }}</td>
                            <td>
                                <ul>
                                    @foreach ($departamento->subdepartamentos as $sub)
                                    <li>{{ $sub->nombre }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('preview');
        const removeButton = document.querySelector('.btn-remove-image');

        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
        removeButton.style.display = 'inline-block';
        document.getElementById('delete_image').value = "0";
    }

    function removeImage() {
        const imageInput = document.getElementById('imagen');
        const imagePreview = document.getElementById('preview');
        const removeButton = document.querySelector('.btn-remove-image');

        imageInput.value = '';
        imagePreview.src = "{{ asset('img/6QQGqDyu_400x400.jpg') }}";
        document.getElementById('delete_image').value = "1";
        removeButton.style.display = 'none';
    }
</script>
@endpush
