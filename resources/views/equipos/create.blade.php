@extends('template')

@section('title', 'Crear Equipo')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Equipo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item active">Crear Equipo</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('equipos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion') }}" required>
                        @error('descripcion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}" required>
                        @error('modelo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Número de Serie -->
                    <div class="col-md-6">
                        <label for="nro_serie" class="form-label">Número de Serie:</label>
                        <input type="text" name="nro_serie" id="nro_serie" class="form-control" value="{{ old('nro_serie') }}" required>
                        @error('nro_serie')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado:</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado') }}" required>
                        @error('estado')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Empresa -->
                    <div class="col-md-6">
                        <label for="empresa_id" class="form-label">Empresa:</label>
                        <select name="empresa_id" id="empresa_id" class="form-control" required>
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('empresa_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Local -->
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local:</label>
                        <select name="local_id" id="local_id" class="form-control" required>
                            <option value="">Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}
                                </option>
                            @endforeach
                        </select>
                        @error('local_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Departamento -->
                    <div class="col-md-6">
                        <label for="departamento_id" class="form-label">Departamento:</label>
                        <select name="departamento_id" id="departamento_id" class="form-control" required>
                            <option value="">Seleccione un departamento</option>
                        </select>
                        @error('departamento_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Subdepartamento -->
                    <div class="col-md-6">
                        <label for="subdepartamento_id" class="form-label">Subdepartamento:</label>
                        <select name="subdepartamento_id" id="subdepartamento_id" class="form-control" required>
                            <option value="">Seleccione un subdepartamento</option>
                        </select>
                        @error('subdepartamento_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Modalidad -->
                    <div class="col-md-6">
                        <label for="modalidades_id" class="form-label">Modalidad:</label>
                        <select name="modalidades_id" id="modalidades_id" class="form-control" required>
                            <option value="">Seleccione una modalidad</option>
                            @foreach($modalidades as $modalidad)
                                <option value="{{ $modalidad->id }}" {{ old('modalidades_id') == $modalidad->id ? 'selected' : '' }}>
                                    {{ $modalidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('modalidades_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Año de Fabricación -->
                    <div class="col-md-6">
                        <label for="anio_fabricacion" class="form-label">Año de Fabricación:</label>
                        <input type="date" name="anio_fabricacion" id="anio_fabricacion" class="form-control" value="{{ old('anio_fabricacion') }}" required>
                        @error('anio_fabricacion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Fecha de Instalación -->
                    <div class="col-md-6">
                        <label for="fecha_instalacion" class="form-label">Fecha de Instalación:</label>
                        <input type="date" name="fecha_instalacion" id="fecha_instalacion" class="form-control" value="{{ old('fecha_instalacion') }}" required>
                        @error('fecha_instalacion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="{{ old('direccion_ip') }}">
                        @error('direccion_ip')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen (Opcional) -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen (Opcional):</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @error('imagen')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <!-- Vista previa de la imagen seleccionada -->
                        <div class="mt-3">
                            <img id="image-preview" src="#" alt="Vista previa de la imagen" class="preview-image" style="display: none;">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image" onclick="removeImage()" style="display: none;">Eliminar imagen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<style>
    .preview-image {
        max-width: 300px;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .btn-remove-image {
        margin-top: 10px;
    }
</style>
@endpush

@push('js')
<script>
    // AJAX para cargar departamentos y subdepartamentos dinámicamente
    document.getElementById('local_id').addEventListener('change', function() {
        const localId = this.value;
        const departamentoSelect = document.getElementById('departamento_id');
        const subdepartamentoSelect = document.getElementById('subdepartamento_id');
        
        departamentoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
        subdepartamentoSelect.innerHTML = '<option value="">Seleccione un subdepartamento</option>';

        if (localId) {
            fetch(`/api/departamentos/${localId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(departamento => {
                        const option = document.createElement('option');
                        option.value = departamento.id;
                        option.textContent = departamento.nombre;
                        departamentoSelect.appendChild(option);
                    });
                });
        }
    });

    document.getElementById('departamento_id').addEventListener('change', function() {
        const departamentoId = this.value;
        const subdepartamentoSelect = document.getElementById('subdepartamento_id');
        
        subdepartamentoSelect.innerHTML = '<option value="">Seleccione un subdepartamento</option>';

        if (departamentoId) {
            fetch(`/api/subdepartamentos/${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subdepartamento => {
                        const option = document.createElement('option');
                        option.value = subdepartamento.id;
                        option.textContent = subdepartamento.nombre;
                        subdepartamentoSelect.appendChild(option);
                    });
                });
        }
    });

    // Función para mostrar la vista previa de la imagen seleccionada
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
