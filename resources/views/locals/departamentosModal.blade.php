<div class="modal fade" id="departamentosModal" tabindex="-1" aria-labelledby="departamentosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom-1">
                <h5 class="modal-title" id="departamentosModalLabel">Gestión de Departamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Formulario de Creación de Departamento -->
                    <div class="col-md-4">
                        <form id="nuevoDepartamentoForm">
                            <div class="mb-3">
                                <label for="nombre_departamento" class="form-label">Nombre</label>
                                <input type="text" id="nombre_departamento" class="form-control" placeholder="Escribe el nombre">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_departamento" class="form-label">Descripción</label>
                                <textarea id="descripcion_departamento" class="form-control" placeholder="Escribe una descripción"></textarea>
                            </div>
                            <button type="button" class="btn btn-success w-100" onclick="agregarDepartamento()">Agregar</button>
                        </form>
                    </div>

                    <!-- Tabla de Departamentos -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Listado de Departamentos</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead id="tablaDepartamentosHeader" style="display: none;">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaDepartamentosTemporales"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón adicional de cerrar -->
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* Ancho de las columnas en la tabla */
    #tablaDepartamentosTemporales td {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    /* Alinear los botones de acciones horizontalmente */
    #tablaDepartamentosTemporales td .btn {
        margin-left: 10px;
    }

    /* Ajustar el tamaño del modal */
    #departamentosModal .modal-dialog {
        max-width: 900px;
    }

    /* Ajustar la altura del listado */
    #departamentosModal .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    /* Botón adicional de cerrar */
    .modal-body .btn-secondary {
        margin-top: 20px;
    }
</style>
