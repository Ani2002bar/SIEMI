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
        <form id="formularioEquipo" action="{{ route('equipos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control"
                            value="{{ old('descripcion') }}" required>
                        @error('descripcion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}"
                            required>
                        @error('modelo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Número de Serie -->
                    <div class="col-md-6">
                        <label for="nro_serie" class="form-label">Número de Serie:</label>
                        <input type="text" name="nro_serie" id="nro_serie" class="form-control"
                            value="{{ old('nro_serie') }}" required>
                        @error('nro_serie')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado:</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
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

                    <!-- Empresa -->
                    <div class="col-md-6">
                        <label for="empresa_id" class="form-label">Empresa:</label>
                        <select name="empresa_id" id="empresa_id" class="form-control">
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

                    <!-- Departamento -->
                    <div class="col-md-6">
                        <label for="departamento_id" class="form-label">Departamento:</label>
                        <select name="departamento_id" id="departamento_id" class="form-control">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Subdepartamento -->
                    <div class="col-md-6">
                        <label for="subdepartamento_id" class="form-label">Subdepartamento:</label>
                        <select name="subdepartamento_id" id="subdepartamento_id" class="form-control">
                            <option value="">Seleccione un subdepartamento</option>
                            @foreach($subdepartamentos as $subdepartamento)
                                <option value="{{ $subdepartamento->id }}" {{ old('subdepartamento_id') == $subdepartamento->id ? 'selected' : '' }}>
                                    {{ $subdepartamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('subdepartamento_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Modalidad -->
                    <div class="col-md-6">
                        <label for="modalidades_id" class="form-label">Modalidad:</label>
                        <select name="modalidades_id" id="modalidades_id" class="form-control">
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
                        <input type="date" name="anio_fabricacion" id="anio_fabricacion" class="form-control"
                            value="{{ old('anio_fabricacion') }}">
                        @error('anio_fabricacion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Fecha de Instalación -->
                    <div class="col-md-6">
                        <label for="fecha_instalacion" class="form-label">Fecha de Instalación:</label>
                        <input type="date" name="fecha_instalacion" id="fecha_instalacion" class="form-control"
                            value="{{ old('fecha_instalacion') }}">
                        @error('fecha_instalacion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" rows="3"
                            class="form-control">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección IP -->
                    <div class="col-md-6">
                        <label for="direccion_ip" class="form-label">Dirección IP:</label>
                        <input type="text" name="direccion_ip" id="direccion_ip" class="form-control"
                            value="{{ old('direccion_ip') }}">
                        @error('direccion_ip')
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
                            <img id="image-preview" src="#" alt="Vista previa de la imagen" class="preview-image"
                                style="display: none;">
                            <button type="button" class="btn btn-secondary btn-sm btn-remove-image"
                                onclick="removeImage()" style="display: none;">Eliminar imagen</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Componentes:</label><br>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#componentesModal">
                            Gestionar Componentes
                        </button>
                        <input type="hidden" name="componentes" id="componentes">

                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
            <button type="button" class="btn btn-primary" onclick="enviarFormulario()">Guardar</button>

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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let componentes = [];
            let currentComponenteId = null;

            function agregarComponente(event) {
                event?.preventDefault(); // Evita el comportamiento predeterminado si se usa un formulario
                const descripcion = document.getElementById('descripcion_componente').value.trim();
                const modelo = document.getElementById('modelo_componente').value.trim();
                const nroSerie = document.getElementById('nro_serie_componente').value.trim();

                if (!descripcion || !modelo) {
                    alert('Descripción y modelo del componente son obligatorios.');
                    return;
                }

                const nuevoComponente = {
                    id: Date.now(),
                    descripcion,
                    modelo,
                    nro_serie: nroSerie,
                    subcomponentes: [],
                };

                componentes.push(nuevoComponente);
                actualizarListaComponentes();
                limpiarFormularioComponente();
            }

            function actualizarListaComponentes() {
                const tabla = document.getElementById('tablaComponentesTemporales');
                tabla.innerHTML = '';
                componentes.forEach((componente, index) => {
                    const fila = `
                    <tr>
                        <td>${componente.descripcion}</td>
                        <td>${componente.modelo}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" onclick="abrirModalSubcomponentes(${index})">Subcomponentes</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(${index})">Eliminar</button>
                        </td>
                    </tr>
                `;
                    tabla.innerHTML += fila;
                });

                // Sincronizar con el input oculto
                document.getElementById('componentes').value = JSON.stringify(componentes);
            }

            function limpiarFormularioComponente() {
                document.getElementById('descripcion_componente').value = '';
                document.getElementById('modelo_componente').value = '';
                document.getElementById('nro_serie_componente').value = '';
            }

            function abrirModalSubcomponentes(index) {
                currentComponenteId = index;
                const componente = componentes[index];
                document.getElementById('subcomponentesModalLabel').textContent = `Subcomponentes de ${componente.descripcion}`;
                actualizarListaSubcomponentes();
                new bootstrap.Modal(document.getElementById('subcomponentesModal')).show();
            }

            function agregarSubcomponente(event) {
                event?.preventDefault(); // Evita el comportamiento predeterminado si se usa un formulario
                const descripcion = document.getElementById('descripcion_subcomponente').value.trim();
                const modelo = document.getElementById('modelo_subcomponente').value.trim();
                const nroSerie = document.getElementById('nro_serie_subcomponente').value.trim();

                if (!descripcion || !modelo) {
                    alert('Descripción y modelo del subcomponente son obligatorios.');
                    return;
                }

                const nuevoSubcomponente = {
                    id: Date.now(),
                    descripcion,
                    modelo,
                    nro_serie: nroSerie,
                };

                componentes[currentComponenteId].subcomponentes.push(nuevoSubcomponente);
                actualizarListaSubcomponentes();
                limpiarFormularioSubcomponente();
            }

            function actualizarListaSubcomponentes() {
                const tabla = document.getElementById('tablaSubcomponentesTemporales');
                tabla.innerHTML = '';
                const subcomponentes = componentes[currentComponenteId].subcomponentes;

                subcomponentes.forEach((subcomponente, index) => {
                    const fila = `
                    <tr>
                        <td>${subcomponente.descripcion}</td>
                        <td>${subcomponente.modelo}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarSubcomponente(${index})">Eliminar</button>
                        </td>
                    </tr>
                `;
                    tabla.innerHTML += fila;
                });
            }

            function limpiarFormularioSubcomponente() {
                document.getElementById('descripcion_subcomponente').value = '';
                document.getElementById('modelo_subcomponente').value = '';
                document.getElementById('nro_serie_subcomponente').value = '';
            }

            function eliminarComponente(index) {
                componentes.splice(index, 1);
                actualizarListaComponentes();
            }

            function eliminarSubcomponente(index) {
                componentes[currentComponenteId].subcomponentes.splice(index, 1);
                actualizarListaSubcomponentes();
            }

            function enviarFormulario() {
                const inputComponentes = document.getElementById('componentes');
                inputComponentes.value = JSON.stringify(componentes);

                // Valida antes de enviar
                if (componentes.length === 0) {
                    alert('Debe añadir al menos un componente antes de guardar.');
                    return;
                }

                document.getElementById('formularioEquipo').submit();
            }

            // Exponer funciones globalmente
            window.agregarComponente = agregarComponente;
            window.abrirModalSubcomponentes = abrirModalSubcomponentes;
            window.agregarSubcomponente = agregarSubcomponente;
            window.eliminarComponente = eliminarComponente;
            window.eliminarSubcomponente = eliminarSubcomponente;
            window.enviarFormulario = enviarFormulario;
        });




    </script>
    <style>
        .required-label::after {
            content: ' *';
            color: red;
        }

        .optional-label::after {
            content: ' (Opcional)';
            color: gray;
            font-weight: normal;
            font-style: italic;
        }

        .required-field {
            border: 2px solid #007bff;
        }
    </style>
@endpush