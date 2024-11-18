@extends('template')

@section('title','Editar Local')

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
    .btn-remove-image {
        background-color: #e0e0e0;
        color: #333;
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

                    <div class="col-md-6">
                        <label for="nombre_local" class="form-label">Nombre del Local:</label>
                        <input type="text" name="nombre_local" id="nombre_local" class="form-control" value="{{ old('nombre_local', $local->nombre_local) }}" required>
                        @error('nombre_local')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $local->direccion) }}" required>
                        @error('direccion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="{{ old('direccion_ip', $local->direccion_ip) }}">
                        @error('direccion_ip')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $local->telefono) }}">
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
                        <div class="mt-2">
                            <p>Vista previa de la imagen:</p>
                            <img id="preview" src="{{ $local->imagen ? asset($local->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}" alt="Imagen del Local" class="preview-image">
                        </div>
                        <button type="button" class="btn btn-remove-image btn-sm mt-2" onclick="removeImage()">Borrar imagen</button>
                        <input type="hidden" name="delete_image" id="delete_image_input" value="0">
                    </div>

                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <button type="reset" class="btn btn-secondary" onclick="resetPreview()">Reiniciar</button>
                <a href="{{ route('locals.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        
        reader.onload = function(){
            const preview = document.getElementById('preview');
            preview.src = reader.result;
        };

        if(input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
        document.getElementById('delete_image_input').value = 0; // Reset delete flag
    }

    function removeImage() {
        const preview = document.getElementById('preview');
        preview.src = "{{ asset('img/6QQGqDyu_400x400.jpg') }}"; // Cambia a la imagen por defecto
        document.getElementById('imagen').value = ''; // Limpiar el campo de archivo
        document.getElementById('delete_image_input').value = 1; // Marcar para eliminar en el servidor
    }

    function resetPreview() {
        const preview = document.getElementById('preview');
        preview.src = "{{ $local->imagen ? asset($local->imagen) : asset('img/6QQGqDyu_400x400.jpg') }}";
        document.getElementById('delete_image_input').value = 0; // Reset delete flag
    }
</script>
@endpush
