<div class="modal fade" id="subdepartamentosModal" tabindex="-1" aria-labelledby="subdepartamentosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subdepartamentosModalLabel">Gestión de Subdepartamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para crear subdepartamento -->
                <form id="createSubDepartamentoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="nuevo_subdepartamento_nombre" class="form-label">Nombre del Subdepartamento:</label>
                        <input type="text" id="nuevo_subdepartamento_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_subdepartamento_descripcion" class="form-label">Descripción:</label>
                        <textarea id="nuevo_subdepartamento_descripcion" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="subdepartamento_departamento_id" class="form-label">Departamento:</label>
                        <select id="subdepartamento_departamento_id" class="form-control">
                            <option value="">Seleccione un departamento</option>
                            <!-- Aquí se cargarán los departamentos dinámicamente -->
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" onclick="guardarSubdepartamento()">Guardar</button>
                    </div>
                </form>

                <hr>

                <!-- Listado de subdepartamentos existentes -->
                <h6>Subdepartamentos Existentes</h6>
                <ul class="list-group" id="listaSubDepartamentos">
                    <!-- Aquí se cargarán los subdepartamentos dinámicamente -->
                </ul>
            </div>
        </div>
    </div>
</div>
