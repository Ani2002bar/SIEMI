@extends('template')

@section('title', 'Registrar Mantenimiento')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Registrar Mantenimiento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mantenimientos.index') }}">Mantenimientos</a></li>
        <li class="breadcrumb-item active">Registrar</li>
    </ol>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mantenimientos.store') }}" method="POST" id="formMantenimiento">
                @csrf

                <!-- Técnico y Local -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tecnico_id" class="form-label">Técnico</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-control">
                            <option value="" selected disabled>Seleccione un técnico</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</option>
                            @endforeach
                        </select>
                        @error('tecnico_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            <option value="" selected disabled>Seleccione un local</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                        @error('local_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Equipo y Costo -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="equipo_id" class="form-label">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-control">
                            <option value="" selected disabled>Seleccione un equipo</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}">{{ $equipo->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('equipo_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="costo_reparacion" class="form-label">Costo Reparación</label>
                        <input type="number" step="0.01" name="costo_reparacion" id="costo_reparacion"
                            class="form-control" readonly>
                    </div>
                </div>

                <!-- Estado y Fecha -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="" selected disabled>Seleccione un estado</option>
                            @foreach($estados as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('estado')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                        @error('fecha')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Descripción</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control"></textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Repuestos -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Repuestos</label>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#repuestosModal">Gestionar Repuestos</button>
                        <input type="hidden" name="repuestos" id="repuestos">
                    </div>
                </div>

                <!-- Botones -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('mantenimientos.repuestosModal')

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
    document.addEventListener("DOMContentLoaded", () => {
        cargarRepuestosExistentes();
    });

    let repuestosExistentes = [];
    let repuestosVinculados = [];

    // Cargar repuestos existentes
    function cargarRepuestosExistentes() {
        fetch("{{ route('api.mantenimientos.repuestos.get') }}")
            .then(response => response.json())
            .then(data => {
                repuestosExistentes = data;
                renderRepuestosExistentes();
            })
            .catch(error => console.error("Error al cargar repuestos:", error));
    }

    // Renderizar repuestos existentes
    function renderRepuestosExistentes() {
        const tbody = document.getElementById("repuestosExistentes");
        tbody.innerHTML = "";

        if (!repuestosExistentes.length) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay repuestos disponibles.</td></tr>';
            return;
        }

        repuestosExistentes.forEach((repuesto, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${repuesto.descripcion}</td>
                    <td>${parseFloat(repuesto.costo).toFixed(2)}</td>
                    <td><button class="btn btn-info btn-sm" onclick="vincularRepuesto(${repuesto.id})">Vincular</button></td>
                </tr>`;
        });
    }

    // Vincular un repuesto
    function vincularRepuesto(id) {
        const repuesto = repuestosExistentes.find(r => r.id === id);
        if (repuesto && !repuestosVinculados.some(r => r.id === id)) {
            repuestosVinculados.push(repuesto);
            renderRepuestosVinculados();
        }
    }

    // Renderizar repuestos vinculados
    function renderRepuestosVinculados() {
        const tbody = document.getElementById("repuestosVinculados");
        tbody.innerHTML = "";

        if (!repuestosVinculados.length) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay repuestos vinculados.</td></tr>';
            return;
        }

        repuestosVinculados.forEach((repuesto, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${repuesto.descripcion}</td>
                    <td><input type="number" class="form-control form-control-sm" value="${parseFloat(repuesto.costo).toFixed(2)}" onchange="editarCosto(${repuesto.id}, this.value)"></td>
                    <td><button class="btn btn-danger btn-sm" onclick="desvincularRepuesto(${repuesto.id})">Desvincular</button></td>
                </tr>`;
        });

        actualizarCostoReparacion();
    }

    // Editar el costo
    function editarCosto(id, costo) {
        const repuesto = repuestosVinculados.find(r => r.id === id);
        if (repuesto) {
            repuesto.costo = parseFloat(costo) || 0;
            actualizarCostoReparacion();
        }
    }

    // Actualizar el costo total
    function actualizarCostoReparacion() {
        const totalCosto = repuestosVinculados.reduce(
            (sum, repuesto) => sum + parseFloat(repuesto.costo),
            0
        );
        document.getElementById("costo_reparacion").value = totalCosto.toFixed(2);
    }

    // Desvincular un repuesto
    function desvincularRepuesto(id) {
        repuestosVinculados = repuestosVinculados.filter(r => r.id !== id);
        renderRepuestosVinculados();
    }

    // Crear un nuevo repuesto
    function crearRepuesto() {
        const repuestoData = {
            nro_parte: document.getElementById("nro_parte_repuesto").value,
            nro_serie: document.getElementById("nro_serie_repuesto").value,
            descripcion: document.getElementById("descripcion_repuesto").value,
            observaciones: document.getElementById("observaciones_repuesto").value,
            costo: parseFloat(document.getElementById("costo_repuesto").value),
        };

        // Validación básica
        if (!repuestoData.descripcion || isNaN(repuestoData.costo)) {
            alert("Por favor, completa los campos obligatorios.");
            return;
        }

        fetch("{{ route('api.mantenimientos.repuestos.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify(repuestoData),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("No se pudo crear el repuesto.");
                }
                return response.json();
            })
            .then(repuesto => {
                alert("Repuesto creado exitosamente.");
                repuestosExistentes.push(repuesto);
                renderRepuestosExistentes();
                document.getElementById("nuevoRepuestoForm").reset(); // Limpiar el formulario
            })
            .catch(error => {
                console.error("Error al crear el repuesto:", error);
                alert("Ocurrió un error al crear el repuesto. Verifica los datos.");
            });
    }

    // Preparar datos antes de enviar
    document.getElementById("formMantenimiento").addEventListener("submit", function () {
        document.getElementById("repuestos").value = JSON.stringify(repuestosVinculados);
    });
</script>

@endpush
