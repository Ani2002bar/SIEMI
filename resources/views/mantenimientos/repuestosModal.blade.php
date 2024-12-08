<style>
   
    /* Sobreescribir modal-open para evitar que cambie el layout del create */
    body.modal-open {
        overflow: visible !important;
    }

    /* Tamaño y estilo del modal */
    .modal-dialog {
        max-width: 80%;
        margin: auto;
    }

    .modal-content {
        border-radius: 8px;
    }

    /* Scroll dentro del modal */
    .modal-body {
        overflow-y: auto;
        max-height: calc(100vh - 150px);
        overflow-x: hidden;
    }

    /* Estilo de los filtros */
    .filter-group {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .filter-group .form-control {
        min-width: 150px;
        max-width: 200px;
    }

    .filter-group .btn {
        height: fit-content;
        align-self: center;
    }

    /* Estilo de la tabla */
    .table thead th {
        background-color: #f5f5f5;
        color: #333;
        font-weight: bold;
    }

    .table tbody tr:hover {
        background-color: #f0f0f0;
    }

    .table tbody tr {
        transition: all 0.2s;
    }

    /* Estilo del scrollbar */
    .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .card-body::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 4px;
    }

    .card-body::-webkit-scrollbar-thumb:hover {
        background-color: #777;
    }
</style>


<div class="modal fade" id="repuestosModal" tabindex="-1" aria-labelledby="repuestosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom-1">
                <h5 class="modal-title" id="repuestosModalLabel">Gestión de Repuestos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Sección 1: Formulario para Crear Repuesto -->
                    <div class="col-md-6">
                        <form id="nuevoRepuestoForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion_repuesto" class="form-label">Descripción</label>
                                    <textarea id="descripcion_repuesto" class="form-control"
                                        placeholder="Descripción del repuesto" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="observaciones_repuesto" class="form-label">Observaciones</label>
                                    <textarea id="observaciones_repuesto" class="form-control"
                                        placeholder="Observaciones (opcional)"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nro_parte_repuesto" class="form-label">Número de Parte</label>
                                    <input type="text" id="nro_parte_repuesto" class="form-control"
                                        placeholder="Número de Parte">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nro_serie_repuesto" class="form-label">Número de Serie</label>
                                    <input type="text" id="nro_serie_repuesto" class="form-control"
                                        placeholder="Número de Serie">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="costo_repuesto" class="form-label">Costo</label>
                                    <input type="number" step="0.01" id="costo_repuesto" class="form-control"
                                        placeholder="Costo del repuesto" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estado_repuesto" class="form-label">Estado</label>
                                    <select id="estado_repuesto" class="form-control" required>
                                        <option value="No Instalado" selected>No Instalado</option>
                                        <option value="Instalado">Instalado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="equipo_id" class="form-label">Equipo</label>
                                    <select id="equipo_id" class="form-control">
                                        <option value="">Seleccione un equipo</option>
                                        @foreach($equipos as $equipo)
                                            <option value="{{ $equipo->id }}">{{ $equipo->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="local_id" class="form-label">Local</label>
                                    <select id="local_id" class="form-control">
                                        <option value="">Seleccione un local</option>
                                        @foreach($locals as $local)
                                            <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="empresa_id" class="form-label">Empresa</label>
                                    <select id="empresa_id" class="form-control">
                                        <option value="">Seleccione una empresa</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="componente_id" class="form-label">Componente</label>
                                    <select id="componente_id" class="form-control">
                                        <option value="">Seleccione un componente</option>
                                        @foreach($componentes as $componente)
                                            <option value="{{ $componente->id }}">{{ $componente->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subcomponente_id" class="form-label">Subcomponente</label>
                                <select id="subcomponente_id" class="form-control">
                                    <option value="">Seleccione un subcomponente</option>
                                    @foreach($subcomponentes as $subcomponente)
                                        <option value="{{ $subcomponente->id }}">{{ $subcomponente->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="crearRepuestoBtn" class="btn btn-success w-100"
                                onclick="crearRepuesto()">Crear</button>
                        </form>
                    </div>

                    <!-- Sección 2: Listado de Repuestos Existentes -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">

                            <div class="card-header bg-primary text-white">

                                <h6 class="mb-0">Repuestos Existentes</h6>
                            </div>
                            
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Costo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="repuestosExistentes">
                                        <!-- Repuestos cargados dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Repuestos Vinculados -->
                <div class="mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Repuestos Vinculados</h6>
                        </div>
                        <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Costo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="repuestosVinculados">
                                    <!-- Repuestos vinculados cargados dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Botón de Cerrar -->
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function filtrarRepuestos() {
    const equipo = document.getElementById("filterEquipo").value;
    const local = document.getElementById("filterLocal").value;
    const empresa = document.getElementById("filterEmpresa").value;

    // Enviar solicitud AJAX al backend
    fetch('{{ route("api.mantenimientos.repuestos.filtered") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            equipo_id: equipo,
            local_id: local,
            empresa_id: empresa,
        }),
    })
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById("repuestosExistentes");
            tbody.innerHTML = ""; // Limpiar la tabla

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay repuestos disponibles.</td></tr>';
            } else {
                data.forEach((repuesto, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${repuesto.descripcion}</td>
                            <td>${parseFloat(repuesto.costo).toFixed(2)}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="vincularRepuesto(${repuesto.id})">Vincular</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        })
        .catch(error => console.error("Error al filtrar repuestos:", error));
}

    function eliminarFiltros() {
    document.getElementById("filterEquipo").value = "";
    document.getElementById("filterLocal").value = "";
    document.getElementById("filterEmpresa").value = "";
    filtrarRepuestos(); // Recargar la tabla sin filtros
}

</script>