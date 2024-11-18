@extends('template')

@section('title', 'Editar Empresa')

@push('css')
<style>
    .preview-image {
        max-width: 150px;
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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
    <h1 class="mt-4 text-center">Editar Empresa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active">Editar Empresa</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('empresas.update', $empresa->id) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Nombre de la Empresa -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $empresa->nombre) }}" required>
                        @error('nombre')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $empresa->direccion) }}" required>
                        @error('direccion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="{{ old('direccion_ip', $empresa->direccion_ip) }}" required>
                        @error('direccion_ip')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $empresa->telefono) }}">
                        @error('telefono')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Selección de Local -->
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local:</label>
                        <select name="local_id" id="local_id" class="form-control" required>
                            <option value="">Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ old('local_id', $empresa->local_id) == $local->id ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                        @error('local_id')
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
                        <div class="mt-2">
                            <p>Vista previa de la imagen:</p>
                            <img id="preview" src="{{ $empresa->imagen ? asset('storage/' . $empresa->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}" alt="Imagen de la empresa" class="preview-image">
                            <button type="button" class="btn btn-remove-image" onclick="removeImage()">Eliminar imagen</button>
                        </div>
                        <input type="hidden" name="delete_image" id="delete_image" value="0">
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empresas.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
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
