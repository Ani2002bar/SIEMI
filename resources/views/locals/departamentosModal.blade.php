<div class="modal fade" id="departamentosModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Gestión de Departamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Formulario de Creación de Departamento -->
                    <div class="col-md-6">
                        <h6>Crear Nuevo Departamento</h6>
                        <form id="nuevoDepartamentoForm">
                            <div class="mb-3">
                                <label for="nombre_departamento" class="form-label">Nombre</label>
                                <input type="text" id="nombre_departamento" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_departamento" class="form-label">Descripción</label>
                                <textarea id="descripcion_departamento" class="form-control"></textarea>
                            </div>
                            <button type="button" class="btn btn-success" onclick="agregarDepartamento()">Agregar</button>
                        </form>
                    </div>

                    <!-- Listado de Departamentos Temporales -->
                    <div class="col-md-6">
                        <h6>Departamentos Temporales</h6>
                        <ul id="listaDepartamentos" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let departamentos = [];

    function agregarDepartamento() {
        const nombre = document.getElementById('nombre_departamento').value;
        const descripcion = document.getElementById('descripcion_departamento').value;

        if (nombre.trim()) {
            departamentos.push({ nombre, descripcion });
            actualizarLista();
            document.getElementById('nuevoDepartamentoForm').reset();
        } else {
            alert('El nombre del departamento es obligatorio.');
        }
    }

    function actualizarLista() {
        const lista = document.getElementById('listaDepartamentos');
        lista.innerHTML = '';

        departamentos.forEach((dep, index) => {
            const item = document.createElement('li');
            item.classList.add('list-group-item');
            item.innerText = `${dep.nombre} - ${dep.descripcion}`;
            lista.appendChild(item);
        });

        document.getElementById('departamentos').value = JSON.stringify(departamentos);
    }
</script>
