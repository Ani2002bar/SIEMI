@extends('template')

@section('title', 'Editar Equipo')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Equipo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item active">Editar Equipo</li>
    </ol>

    <div class="card text-bg-light">
        <form id="formularioEquipo" action="{{ route('equipos.update', $equipo->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="row g-4">
                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control"
                            value="{{ old('descripcion', $equipo->descripcion) }}">
                        @error('descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" class="form-control"
                            value="{{ old('modelo', $equipo->modelo) }}" required>
                        @error('modelo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Número de Serie -->
                    <div class="col-md-6">
                        <label for="nro_serie" class="form-label">Número de Serie:</label>
                        <input type="text" name="nro_serie" id="nro_serie" class="form-control"
                            value="{{ old('nro_serie', $equipo->nro_serie) }}" required>
                        @error('nro_serie')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div class="col-md-6">
                        <label for="marca" class="form-label">Marca:</label>
                        <input type="text" name="marca" id="marca" class="form-control"
                            value="{{ old('marca', $equipo->marca) }}">
                        @error('marca')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control"
                            value="{{ old('direccion_ip', $equipo->direccion_ip) }}">
                        @error('direccion_ip')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="Activo" {{ old('estado', $equipo->estado) == 'Activo' ? 'selected' : '' }}>
                                Activo</option>
                            <option value="Inactivo" {{ old('estado', $equipo->estado) == 'Inactivo' ? 'selected' : '' }}>
                                Inactivo</option>
                        </select>
                        @error('estado')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Local -->
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local:</label>
                        <select name="local_id" id="local_id" class="form-control" required>
                            <option value="">Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ old('local_id', $equipo->local_id) == $local->id ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}
                                </option>
                            @endforeach
                        </select>
                        @error('local_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Empresa -->
                    <div class="col-md-6">
                        <label for="empresa_id" class="form-label">Empresa:</label>
                        <select name="empresa_id" id="empresa_id" class="form-control">
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ old('empresa_id', $equipo->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('empresa_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Departamento -->
                    <div class="col-md-6">
                        <label for="departamento_id" class="form-label">Departamento:</label>
                        <select name="departamento_id" id="departamento_id" class="form-control">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id', $equipo->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Subdepartamento -->
                    <div class="col-md-6">
                        <label for="subdepartamento_id" class="form-label">Subdepartamento:</label>
                        <select name="subdepartamento_id" id="subdepartamento_id" class="form-control">
                            <option value="">Seleccione un subdepartamento</option>
                            @foreach($subdepartamentos as $subdepartamento)
                                <option value="{{ $subdepartamento->id }}" {{ old('subdepartamento_id', $equipo->subdepartamento_id) == $subdepartamento->id ? 'selected' : '' }}>
                                    {{ $subdepartamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('subdepartamento_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Año de Fabricación -->
                    <div class="col-md-6">
                        <label for="anio_fabricacion" class="form-label">Año de Fabricación:</label>
                        <input type="date" name="anio_fabricacion" id="anio_fabricacion" class="form-control"
                            value="{{ old('anio_fabricacion', $equipo->anio_fabricacion) }}">
                        @error('anio_fabricacion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Fecha de Instalación -->
                    <div class="col-md-6">
                        <label for="fecha_instalacion" class="form-label">Fecha de Instalación:</label>
                        <input type="date" name="fecha_instalacion" id="fecha_instalacion" class="form-control"
                            value="{{ old('fecha_instalacion', $equipo->fecha_instalacion) }}">
                        @error('fecha_instalacion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Modalidad -->
                    <div class="col-md-6">
                        <label for="modalidades_id" class="form-label">Modalidad:</label>
                        <select name="modalidades_id" id="modalidades_id" class="form-control">
                            <option value="">Seleccione una modalidad</option>
                            @foreach($modalidades as $modalidad)
                                <option value="{{ $modalidad->id }}" {{ old('modalidades_id', $equipo->modalidades_id) == $modalidad->id ? 'selected' : '' }}>
                                    {{ $modalidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('modalidades_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" rows="3"
                            class="form-control">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                            onchange="previewImage(event)">
                        <div class="mt-2">
                            @if($equipo->imagen)
                                <img id="image-preview" src="{{ asset($equipo->imagen) }}" alt="Vista previa" class="img-thumbnail">
                            @endif
                        </div>
                        @error('imagen')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Componentes -->
                    <div class="col-md-6">
                        <label class="form-label">Componentes:</label>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#componentesModal">
                            Gestionar Componentes
                        </button>
                        <input type="hidden" name="componentes" id="componentes">
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-danger">Cancelar</a>
            </div>

            @include('equipos.componentesModal')
            @include('equipos.subcomponentesModal')
        </form>
    </div>
</div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funciones para manejo de la imagen
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('delete_image_input').value = 0;
        }

        function removeImage() {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = "{{ asset('img/default.png') }}";
            document.getElementById('imagen').value = '';
            document.getElementById('delete_image_input').value = 1;
        }
    </script>


    <script>

        let componentes = @json($componentes);

        document.addEventListener('DOMContentLoaded', () => {
            actualizarListaComponentes();

            // Sincronizar componentes y subcomponentes antes de enviar el formulario
            document.querySelector('form').addEventListener('submit', () => {
                document.getElementById('componentes').value = JSON.stringify(componentes);
            });
        });

        function actualizarListaComponentes() {
            const tabla = document.getElementById('tablaComponentesTemporales');
            tabla.innerHTML = ''; // Limpiar la tabla

            componentes.forEach((componente, index) => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                <td>${componente.descripcion || '(Sin descripción)'}</td>
                <td>${componente.modelo || '(Sin modelo)'}</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="abrirModalSubcomponentes(${index})">Gestionar Subcomponentes</button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarComponente(${index})">Eliminar</button>
                </td>
            `;
                tabla.appendChild(fila);
            });
        }

        function agregarComponente() {
            const descripcion = document.getElementById('descripcion_componente').value.trim();
            const modelo = document.getElementById('modelo_componente').value.trim();

            if (!descripcion) {
                alert('La descripción del componente es obligatoria.');
                return;
            }

            componentes.push({
                id: Date.now(), // Generar un ID único temporal
                descripcion,
                modelo,
                subcomponentes: []
            });

            actualizarListaComponentes();
            document.getElementById('nuevoComponenteForm').reset();
        }

        function eliminarComponente(index) {
            componentes.splice(index, 1); // Eliminar componente por índice
            actualizarListaComponentes();
        }

        function abrirModalSubcomponentes(componenteIndex) {
            const componente = componentes[componenteIndex];
            if (!componente) return;

            document.getElementById('subcomponentesModal').setAttribute('data-componente-index', componenteIndex);
            document.getElementById('subcomponentesModalLabel').textContent = `Subcomponentes de: ${componente.descripcion}`;
            actualizarListaSubcomponentes(componenteIndex);

            const modal = new bootstrap.Modal(document.getElementById('subcomponentesModal'));
            modal.show();
        }

        function actualizarListaSubcomponentes(componenteIndex) {
            const tabla = document.getElementById('tablaSubcomponentesTemporales');
            tabla.innerHTML = ''; // Limpiar la tabla

            const subcomponentes = componentes[componenteIndex].subcomponentes;

            subcomponentes.forEach((subcomponente, index) => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                <td>${subcomponente.descripcion || '(Sin descripción)'}</td>
                <td>${subcomponente.modelo || '(Sin modelo)'}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="eliminarSubcomponente(${componenteIndex}, ${index})">Eliminar</button>
                </td>
            `;
                tabla.appendChild(fila);
            });
        }

        function agregarSubcomponente() {
            const descripcion = document.getElementById('descripcion_subcomponente').value.trim();
            const modelo = document.getElementById('modelo_subcomponente').value.trim();

            if (!descripcion) {
                alert('La descripción del subcomponente es obligatoria.');
                return;
            }

            const componenteIndex = document.getElementById('subcomponentesModal').getAttribute('data-componente-index');
            const componente = componentes[componenteIndex];

            componente.subcomponentes.push({
                id: Date.now(), // Generar un ID único temporal
                descripcion,
                modelo
            });

            actualizarListaSubcomponentes(componenteIndex);
            document.getElementById('nuevoSubcomponenteForm').reset();
        }

        function eliminarSubcomponente(componenteIndex, subcomponenteIndex) {
            const componente = componentes[componenteIndex];
            componente.subcomponentes.splice(subcomponenteIndex, 1); // Eliminar subcomponente por índice
            actualizarListaSubcomponentes(componenteIndex);
        }




    </script>


@endpush