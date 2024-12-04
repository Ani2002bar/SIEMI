<div class="modal fade" id="empresasModal" tabindex="-1" aria-labelledby="empresasModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom-1">
                <h5 class="modal-title" id="empresasModalLabel">Gestión de Empresas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Sección 1: Formulario para Crear Empresa -->
                    <div class="col-md-4">
                        <form id="nuevaEmpresaForm">
                            <div class="mb-3">
                                <label for="nombre_empresa" class="form-label">Nombre</label>
                                <input type="text" id="nombre_empresa" class="form-control" placeholder="Nombre de la empresa">
                            </div>
                            <div class="mb-3">
                                <label for="direccion_empresa" class="form-label">Dirección</label>
                                <input type="text" id="direccion_empresa" class="form-control" placeholder="Dirección de la empresa">
                            </div>
                            <div class="mb-3">
                                <label for="direccion_ip_empresa" class="form-label">Dirección IP</label>
                                <input type="text" id="direccion_ip_empresa" class="form-control" placeholder="IP de la empresa">
                            </div>
                            <div class="mb-3">
                                <label for="telefono_empresa" class="form-label">Teléfono</label>
                                <input type="text" id="telefono_empresa" class="form-control" placeholder="Teléfono de la empresa">
                            </div>
                            <div class="mb-3">
                                <label for="imagen_empresa" class="form-label">Imagen (Opcional)</label>
                                <input type="file" id="imagen_empresa" class="form-control" accept="image/*" onchange="previewEmpresaImage(event)">
                                <div class="mt-3">
                                    <img id="empresa-image-preview" src="#" alt="Vista previa de la imagen" class="preview-image" style="display: none;">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-image" onclick="removeEmpresaImage()" style="display: none;">Eliminar imagen</button>
                                </div>
                            </div>
                            <button type="button" id="crearEmpresaBtn" class="btn btn-success w-100" onclick="crearEmpresa()">Crear</button>
                        </form>
                    </div>

                    <!-- Sección 2: Listado de Empresas Existentes -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Empresas Existentes</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empresasExistentes">
                                            <!-- Empresas cargadas dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Empresas Vinculadas -->
                <div class="mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Empresas Vinculadas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="empresasVinculadas">
                                        <!-- Empresas vinculadas cargadas dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
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

<style>
    #empresasModal .modal-dialog {
        max-width: 900px;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    .table th,
    .table td {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .preview-image {
        max-width: 200px;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ddd;
        display: none;
    }

    .btn-remove-image {
        margin-top: 10px;
        display: none;
    }
</style>

<script>
    let empresasExistentes = [];
    if (typeof empresasVinculadas === 'undefined') {
    var empresasVinculadas = [];
}
    document.addEventListener('DOMContentLoaded', () => {
        cargarEmpresasExistentes();
    });

    function cargarEmpresasExistentes() {
        fetch('{{ route("api.empresas.get") }}')
            .then(response => response.json())
            .then(data => {
                empresasExistentes = data;
                renderEmpresasExistentes();
            })
            .catch(error => console.error('Error:', error));
    }

    function renderEmpresasExistentes() {
        const tbody = document.getElementById('empresasExistentes');
        tbody.innerHTML = '';
        empresasExistentes.forEach(empresa => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${empresa.nombre}</td>
                <td>${empresa.direccion}</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="vincularEmpresa(${empresa.id})">Vincular</button>
                </td>`;
            tbody.appendChild(row);
        });
    }

    function renderEmpresasVinculadas() {
        const tbody = document.getElementById('empresasVinculadas');
        tbody.innerHTML = '';
        empresasVinculadas.forEach(empresa => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${empresa.nombre}</td>
                <td>${empresa.direccion}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="desvincularEmpresa(${empresa.id})">Desvincular</button>
                </td>`;
            tbody.appendChild(row);
        });

        // Actualizar el campo oculto con las empresas vinculadas
        document.getElementById('empresas').value = JSON.stringify(empresasVinculadas);
    }

    function crearEmpresa() {
        const formData = new FormData();
        formData.append('nombre', document.getElementById('nombre_empresa').value.trim());
        formData.append('direccion', document.getElementById('direccion_empresa').value.trim());
        formData.append('direccion_ip', document.getElementById('direccion_ip_empresa').value.trim());
        formData.append('telefono', document.getElementById('telefono_empresa').value.trim());

        const imagenInput = document.getElementById('imagen_empresa');
        if (imagenInput.files[0]) {
            formData.append('imagen', imagenInput.files[0]);
        }

        fetch('{{ route("empresas.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    // Agregar la empresa creada a la lista
                    empresasExistentes.push(data);
                    renderEmpresasExistentes();
                    document.getElementById('nuevaEmpresaForm').reset();
                    removeEmpresaImage(); // Limpia la vista previa de la imagen
                } else {
                    alert('Error al crear la empresa.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function previewEmpresaImage(event) {
        const imagePreview = document.getElementById('empresa-image-preview');
        const removeButton = document.querySelector('.btn-remove-image');

        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
        removeButton.style.display = 'inline-block';
    }

    function removeEmpresaImage() {
        const imageInput = document.getElementById('imagen_empresa');
        const imagePreview = document.getElementById('empresa-image-preview');
        const removeButton = document.querySelector('.btn-remove-image');

        imageInput.value = '';
        imagePreview.style.display = 'none';
        removeButton.style.display = 'none';
    }

    function vincularEmpresa(id) {
        const empresa = empresasExistentes.find(emp => emp.id === id);
        if (empresa && !empresasVinculadas.some(emp => emp.id === id)) {
            empresasVinculadas.push(empresa);
            renderEmpresasVinculadas();
        }
    }

    function desvincularEmpresa(id) {
        empresasVinculadas = empresasVinculadas.filter(emp => emp.id !== id);
        renderEmpresasVinculadas();
    }
    
</script>
