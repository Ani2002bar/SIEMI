<div class="modal fade" id="localsModal" tabindex="-1" aria-labelledby="localsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="localsModalLabel">Gestión de Locals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Locals Existentes -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Locals Disponibles</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="localsExistentes">
                                            <!-- Locals dinámicos -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Locals Vinculados -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Locals Vinculados</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="localsVinculados">
                                            <!-- Locals vinculados -->
                                        </tbody>
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
    /* Estilos generales del modal */
    #localsModal .modal-header {
        background-color: #f8f9fa; /* Fondo claro */
        border-bottom: 0px solid #ddd; /* Línea divisoria */
    }

    #localsModal .modal-content {
        border-radius: 0px;
        border: 0px solid #ddd;
    }

    /* Estilo de las tarjetas (Locals Disponibles y Vinculados) */
    #localsModal .card {
        border: 0px solid #ddd;
        border-radius: 0px;
    }

    #localsModal .card-header {
        font-weight: bold;
        font-size: 0.95em;
        text-align: center;
    }

    #localsModal .card-header.bg-primary {
        background-color: #0d6efd;
    }

    #localsModal .card-header.bg-success {
        background-color: #198754;
    }

    #localsModal .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Sombra clara al pasar el cursor */
    }

    /* Estilo para los botones dentro de las tablas */
    #localsModal .table tbody .btn {
        font-size: 0.85em;
        padding: 4px 8px;
        border-radius: 4px;
    }

    #localsModal .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: white;
    }

    #localsModal .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    /* Espaciado entre las dos secciones */
    #localsModal .col-md-6 {
        padding: 0 10px;
    }

    /* Responsive: ajusta la altura de las tablas */
    #localsModal .table-responsive {
        max-height: 300px;
        overflow-y: auto;
    }

    /* Botón Cerrar */
    #localsModal .btn-secondary {
        font-size: 1em;
        padding: 10px 20px;
        border-radius: 6px;
    }
</style>
