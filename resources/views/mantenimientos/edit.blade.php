@extends('template')

@section('title', 'Editar Mantenimiento')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Mantenimiento</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mantenimientos.index') }}">Mantenimientos</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mantenimientos.update', $mantenimiento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Técnico y Local -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tecnico_id" class="form-label">Técnico</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-control">
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ $tecnico->id == $mantenimiento->tecnico_id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="local_id" class="form-label">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local->id == $mantenimiento->local_id ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Equipo y Costo Reparación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="equipo_id" class="form-label">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-control">
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" {{ $equipo->id == $mantenimiento->equipo_id ? 'selected' : '' }}>
                                    {{ $equipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="costo_reparacion" class="form-label">Costo Reparación</label>
                        <input type="number" step="0.01" name="costo_reparacion" id="costo_reparacion" class="form-control" value="{{ $costoReparacion }}" readonly>
                    </div>
                </div>

                <!-- Estado y Fecha -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="pendiente" {{ $mantenimiento->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="finalizado" {{ $mantenimiento->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $mantenimiento->fecha }}">
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Descripción:</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control">{{ $mantenimiento->observaciones }}</textarea>
                    </div>
                </div>

                <!-- Repuestos -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Repuestos</label>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repuestosModal">
                            Gestionar Repuestos
                        </button>
                        <input type="hidden" name="repuestos" id="repuestos" value="{{ json_encode($repuestosVinculados) }}">
                    </div>
                </div>

                <!-- Botones -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('mantenimientos.repuestosModal', [
    'repuestosVinculados' => $repuestosVinculados,
    'repuestos' => $repuestos,
])

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        cargarRepuestosExistentes();
        renderRepuestosVinculados();
    });

    let repuestosExistentes = [];
    let repuestosVinculados = JSON.parse(document.getElementById("repuestos").value || "[]");

    // Cargar los repuestos existentes desde el backend
    function cargarRepuestosExistentes() {
        fetch("{{ route('api.mantenimientos.repuestos.get') }}")
            .then((response) => response.json())
            .then((data) => {
                repuestosExistentes = data;
                renderRepuestosExistentes();
            })
            .catch((error) => console.error("Error al cargar repuestos:", error));
    }

    // Renderizar los repuestos existentes en el modal
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
                    <td>
                        <button class="btn btn-info btn-sm" onclick="vincularRepuesto(${repuesto.id})">Vincular</button>
                    </td>
                </tr>`;
        });
    }

    // Vincular un repuesto al mantenimiento
    function vincularRepuesto(id) {
        const repuesto = repuestosExistentes.find((r) => r.id === id);
        if (repuesto && !repuestosVinculados.some((r) => r.id === id)) {
            repuestosVinculados.push({ ...repuesto, cantidad: 1 }); // Añadir cantidad por defecto
            renderRepuestosVinculados();
        }
    }

    // Renderizar los repuestos vinculados
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
                    <td>
                        <input type="number" step="0.01" class="form-control" value="${parseFloat(repuesto.costo).toFixed(2)}" onchange="actualizarCostoRepuesto(${repuesto.id}, this.value)">
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="desvincularRepuesto(${repuesto.id})">Desvincular</button>
                    </td>
                </tr>`;
        });

        actualizarCostoReparacion();
    }

    // Crear un nuevo repuesto
    function crearRepuesto() {
        const descripcion = document.getElementById("descripcion_repuesto").value.trim();
        const costo = parseFloat(document.getElementById("costo_repuesto").value);

        // Validaciones
        if (!descripcion || isNaN(costo) || costo <= 0) {
            alert("Por favor, complete correctamente los campos del repuesto.");
            return;
        }

        const nuevoRepuesto = { descripcion, costo };

        fetch("{{ route('api.mantenimientos.repuestos.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify(nuevoRepuesto),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al crear el repuesto.");
                }
                return response.json();
            })
            .then((repuesto) => {
                alert("Repuesto creado exitosamente.");
                repuestosExistentes.push(repuesto);
                renderRepuestosExistentes();
                document.getElementById("nuevoRepuestoForm").reset(); // Limpiar el formulario
            })
            .catch((error) => console.error("Error al crear el repuesto:", error));
    }

    // Actualizar el costo de un repuesto vinculado
    function actualizarCostoRepuesto(id, nuevoCosto) {
        const repuesto = repuestosVinculados.find((r) => r.id === id);
        if (repuesto) {
            repuesto.costo = parseFloat(nuevoCosto) || 0;
            actualizarCostoReparacion();
        }
    }

    // Desvincular un repuesto
    function desvincularRepuesto(id) {
        repuestosVinculados = repuestosVinculados.filter((r) => r.id !== id);
        renderRepuestosVinculados();
    }

    // Calcular y mostrar el costo total de la reparación
    function actualizarCostoReparacion() {
        const totalCosto = repuestosVinculados.reduce((sum, repuesto) => sum + parseFloat(repuesto.costo || 0), 0);
        document.getElementById("costo_reparacion").value = totalCosto.toFixed(2);
    }

    // Sincronizar los datos antes de enviar el formulario
    document.querySelector("form").addEventListener("submit", function () {
        document.getElementById("repuestos").value = JSON.stringify(repuestosVinculados);
    });
</script>


@endsection
