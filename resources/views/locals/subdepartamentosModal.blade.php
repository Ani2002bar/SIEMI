<div class="modal fade" id="subdepartamentosModal" tabindex="-1" aria-labelledby="subdepartamentosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="subdepartamentosModalLabel">Gestión de Subdepartamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <form id="nuevoSubdepartamentoForm">
                            <div class="mb-3">
                                <label for="nombre_subdepartamento" class="form-label">Nombre</label>
                                <input type="text" id="nombre_subdepartamento" class="form-control" placeholder="Nombre del subdepartamento">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_subdepartamento" class="form-label">Descripción</label>
                                <textarea id="descripcion_subdepartamento" class="form-control" placeholder="Descripción"></textarea>
                            </div>
                            <button type="button" class="btn btn-success w-100" onclick="agregarSubdepartamento()">Agregar</button>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Listado de Subdepartamentos</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead id="tablaSubdepartamentosHeader" style="display: none;">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaSubdepartamentosTemporales"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    /* Estilo para el modal con estética clara */
    #subdepartamentosModal .modal-header {
        background-color: #f8f9fa; /* Fondo claro */
    }

    #subdepartamentosModal .modal-content {
        border-radius: 8px; /* Bordes suaves */
        border: 1px solid #ddd; /* Borde ligero */
    }

    #subdepartamentosModal .card-header {
        background-color: #0d6efd; /* Azul Bootstrap */
        color: white; /* Texto blanco */
    }

    #subdepartamentosModal .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
        border-color: #0d6efd;
    }

    #subdepartamentosModal .btn-secondary {
        margin-top: 20px;
    }

    /* Altura ajustada para el listado */
    #subdepartamentosModal .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    /* Espaciado en botones */
    #tablaSubdepartamentosTemporales td .btn {
        margin-left: 10px;
    }

    /* Sin bordes adicionales para mantener estética clara */
</style>
