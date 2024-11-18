@extends('template')

@section('title', 'Crear Local')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
    .preview-image {
        max-width: 300px;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ddd;
        display: none; /* Oculta la imagen al inicio */
    }
    .btn-remove-image {
        display: none; /* Oculta el botón al inicio */
        margin-top: 10px;
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
                    <div class="col-md-6">
                        <label for="nombre_local" class="form-label">Nombre del Local:</label>
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control" value="{{ old('nombre_local') }}" required>
                        @error('nombre_local')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
                        @error('direccion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="{{ old('direccion_ip') }}">
                        @error('direccion_ip')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                        @error('telefono')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen (Opcional):</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @error('imagen')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <!-- Vista previa de la imagen seleccionada -->
                        <div class="mt-3">
                            <img id="image-preview" src="#" alt="Vista previa de la imagen" class="preview-image">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image" onclick="removeImage()">Eliminar imagen</button>
                        </div>
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

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

<script>
    // Función para mostrar la vista previa de la imagen seleccionada y el botón de eliminación
    function previewImage(event) {
        const imagePreview = document.getElementById('image-preview');
        const removeButton = document.querySelector('.btn-remove-image');
        
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
        removeButton.style.display = 'inline-block';
    }

    // Función para eliminar la imagen seleccionada y restablecer el campo de archivo
    function removeImage() {
        const imageInput = document.getElementById('imagen');
        const imagePreview = document.getElementById('image-preview');
        const removeButton = document.querySelector('.btn-remove-image');

        imageInput.value = ''; // Limpia el campo de archivo
        imagePreview.style.display = 'none';
        removeButton.style.display = 'none';
    }
</script>
@endpush