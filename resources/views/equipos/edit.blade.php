@extends('template')

@section('title', 'Editar Equipo')

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
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Equipo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item active">Editar Equipo</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('equipos.update', $equipo->id) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $equipo->descripcion) }}" required>
                        @error('descripcion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo', $equipo->modelo) }}" required>
                        @error('modelo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Número de Serie -->
                    <div class="col-md-6">
                        <label for="nro_serie" class="form-label">Número de Serie:</label>
                        <input type="text" name="nro_serie" id="nro_serie" class="form-control" value="{{ old('nro_serie', $equipo->nro_serie) }}" required>
                        @error('nro_serie')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado:</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado', $equipo->estado) }}" required>
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
                                <option value="{{ $empresa->id }}" {{ old('empresa_id', $equipo->empresa_id) == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
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
                                <option value="{{ $local->id }}" {{ old('local_id', $equipo->local_id) == $local->id ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
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
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id', $equipo->departamento_id) == $departamento->id ? 'selected' : '' }}>{{ $departamento->nombre }}</option>
                            @endforeach
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
                            @foreach($subdepartamentos as $subdepartamento)
                                <option value="{{ $subdepartamento->id }}" {{ old('subdepartamento_id', $equipo->subdepartamento_id) == $subdepartamento->id ? 'selected' : '' }}>{{ $subdepartamento->nombre }}</option>
                            @endforeach
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
                                <option value="{{ $modalidad->id }}" {{ old('modalidades_id', $equipo->modalidades_id) == $modalidad->id ? 'selected' : '' }}>{{ $modalidad->nombre }}</option>
                            @endforeach
                        </select>
                        @error('modalidades_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Año de Fabricación -->
                    <div class="col-md-6">
                        <label for="anio_fabricacion" class="form-label">Año de Fabricación:</label>
                        <input type="date" name="anio_fabricacion" id="anio_fabricacion" class="form-control" value="{{ old('anio_fabricacion', $equipo->anio_fabricacion) }}" required>
                        @error('anio_fabricacion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Fecha de Instalación -->
                    <div class="col-md-6">
                        <label for="fecha_instalacion" class="form-label">Fecha de Instalación:</label>
                        <input type="date" name="fecha_instalacion" id="fecha_instalacion" class="form-control" value="{{ old('fecha_instalacion', $equipo->fecha_instalacion) }}" required>
                        @error('fecha_instalacion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                        @error('observaciones')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="{{ old('direccion_ip', $equipo->direccion_ip) }}">
                        @error('direccion_ip')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen (Opcional):</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @error('imagen')
                        <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                        <div class="mt-2">
                            <p>Vista previa de la imagen:</p>
                            <img id="preview" src="{{ $equipo->imagen }}" alt="Imagen del Equipo" class="preview-image">

                        </div>
                        <button type="button" class="btn btn-remove-image btn-sm" onclick="removeImage()">Eliminar imagen</button>
                        <input type="hidden" name="delete_image" id="delete_image_input" value="0">
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
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

    function previewImage(event) {
        const imagePreview = document.getElementById('preview');
        const removeButton = document.querySelector('.btn-remove-image');
        
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
        removeButton.style.display = 'inline-block';
        document.getElementById('delete_image_input').value = 0;
    }

    function removeImage() {
    const preview = document.getElementById('preview');
    preview.src = "{{ asset('img/6QQGqDyu_400x400.jpg') }}";
    document.getElementById('imagen').value = '';
    document.getElementById('delete_image_input').value = 1;
}

</script>
@endpush
