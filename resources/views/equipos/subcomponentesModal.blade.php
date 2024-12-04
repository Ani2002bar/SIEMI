<div class="modal fade" id="subcomponentesModal" tabindex="-1" aria-labelledby="subcomponentesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="subcomponentesModalLabel">Gestión de Subcomponentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Formulario de Creación de Subcomponente -->
                    <div class="col-md-4">
                        <form id="nuevoSubcomponenteForm">
                            <div class="mb-3">
                                <label for="descripcion_subcomponente" class="form-label">Descripción</label>
                                <input type="text" id="descripcion_subcomponente" class="form-control" placeholder="Descripción">
                            </div>
                            <div class="mb-3">
                                <label for="modelo_subcomponente" class="form-label">Modelo</label>
                                <input type="text" id="modelo_subcomponente" class="form-control" placeholder="Modelo">
                            </div>
                            <div class="mb-3">
                                <label for="nro_serie_subcomponente" class="form-label">Número de Serie</label>
                                <input type="text" id="nro_serie_subcomponente" class="form-control" placeholder="Número de Serie">
                            </div>
                            <button type="button" class="btn btn-success w-100" onclick="agregarSubcomponente()">Agregar Subcomponente</button>
                        </form>
                    </div>
                    <!-- Tabla de Subcomponentes -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">Lista de Subcomponentes</h6>
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
                                        <tbody id="tablaSubcomponentesTemporales"></tbody>
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
    /* Ajuste del modal */
    #subcomponentesModal .modal-header {
        background-color: #f8f9fa; /* Fondo claro */
    }

    #subcomponentesModal .modal-content {
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    #subcomponentesModal .card-header {
        background-color: #0d6efd;
        color: white;
    }

    #subcomponentesModal .btn-secondary {
        margin-top: 20px;
    }

    /* Altura ajustada para el listado */
    #subcomponentesModal .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
</style>
