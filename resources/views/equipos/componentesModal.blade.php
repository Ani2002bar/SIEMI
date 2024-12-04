<div class="modal fade" id="componentesModal" tabindex="-1" aria-labelledby="componentesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="componentesModalLabel">Gestión de Componentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Formulario de Creación de Componente -->
                    <div class="col-md-4">
                        <form id="nuevoComponenteForm">
                            <div class="mb-3">
                                <label for="descripcion_componente" class="form-label">Descripción</label>
                                <input type="text" id="descripcion_componente" class="form-control" placeholder="Descripción">
                            </div>
                            <div class="mb-3">
                                <label for="modelo_componente" class="form-label">Modelo</label>
                                <input type="text" id="modelo_componente" class="form-control" placeholder="Modelo">
                            </div>
                            <div class="mb-3">
                                <label for="nro_serie_componente" class="form-label">Número de Serie</label>
                                <input type="text" id="nro_serie_componente" class="form-control" placeholder="Número de Serie">
                            </div>
                            <button type="button" class="btn btn-success w-100" onclick="agregarComponente()">Agregar Componente</button>
                        </form>
                    </div>
                    <!-- Tabla de Componentes -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">Lista de Componentes</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Modelo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaComponentesTemporales"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<style>
    /* Ancho de las columnas en la tabla */
    #tablaComponentesTemporales td {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    /* Alinear los botones de acciones horizontalmente */
    #tablaComponentesTemporales td .btn {
        margin-left: 10px;
    }

    /* Ajustar el tamaño del modal */
    #componentesModal .modal-dialog {
        max-width: 900px;
    }

    /* Ajustar la altura del listado */
    #componentesModal .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
</style>
