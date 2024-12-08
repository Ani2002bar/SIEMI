@extends('template')

@section('title', 'Equipos')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .filter-title {
            font-weight: bold;
            font-size: 1em;
            margin-bottom: 5px;
            text-align: center;
        }

        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .filter-container .form-group {
            min-width: 120px;
            flex: 1;
        }

        .filter-container label {
            font-size: 0.85em;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .action-buttons .btn {
            border-radius: 5px;
            padding: 6px 12px;
            margin: 0 3px;
        }

        #clearFiltersButton {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.85em;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Equipos</h1>
</div>
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('equipos.create') }}">
        <button type="button" class="btn btn-primary me-2">Añadir nuevo equipo</button>
    </a>
    <a href="#" data-toggle="modal" data-target="#filtrosModal">
        <button type="button" class="btn btn-primary me-2" data-toggle="modal" data-target="#filtrosModal">
            <i class="fas fa-file-pdf"></i> Generar Informe</button>
    </a>
</div>
@include('equipos.filtrosModal')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="filter-container">
            <!-- Filtro por Empresa -->
            <div class="form-group">
                <label for="empresa_id">Empresa</label>
                <select name="empresa_id" id="empresa_id" class="form-control form-control-sm">
    <option value="">Todas</option>
    @foreach($empresas as $empresa)
        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
    @endforeach
</select>
            </div>

            <!-- Filtro por Modalidad -->
            <div class="form-group">
                <label for="modalidad_id">Modalidad</label>
                <select name="modalidad_id" id="modalidad_id" class="form-control form-control-sm">
                    <option value="">Todas</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->id }}">{{ $modalidad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Local -->
            <div class="form-group">
                <label for="local_id">Local</label>
                <select name="local_id" id="local_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>


            <!-- Botón para eliminar filtros -->
            <button type="button" id="clearFiltersButton" class="btn btn-secondary btn-sm">Eliminar filtros</button>
        </div>
    </div>



    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Número de Serie</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->descripcion }}</td>
                            <td>{{ $equipo->nro_serie }}</td>
                            <td>{{ $equipo->estado }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-detalles btn-sm">
                                        <i class="fas fa-info-circle"></i> Detalles
                                    </a>
                                    <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-editar btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <button type="button" class="btn btn-eliminar btn-sm"
                                        onclick="confirmDelete({{ $equipo->id }})">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                ¿Seguro que quieres eliminar este equipo?
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <form id="deleteForm" action="" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   
<script>
   $(document).ready(function () {
    // Initialize DataTable
    $('#dataTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    // Escuchar cambios en filtros
    $('#empresa_id, #modalidad_id, #local_id, #estado').on('change', function () {
        applyFilters();
    });

    // Botón para limpiar filtros
    $('#clearFiltersButton').on('click', function () {
        clearFilters();
    });
});

// Función para aplicar los filtros
function applyFilters() {
    const params = {
        empresa_id: $('#empresa_id').val(),
        modalidad_id: $('#modalidad_id').val(),
        local_id: $('#local_id').val(),
        estado: $('#estado').val(),
    };

    $.ajax({
        url: "{{ route('equipos.index') }}",
        method: "GET",
        data: params,
        success: function (response) {
            updateTable(response.equipos);
        },
        error: function () {
            console.error('Error al filtrar los datos.');
        },
    });
}

// Función para actualizar la tabla con los datos filtrados
function updateTable(equipos) {
    const tbody = $('#dataTable tbody');
    tbody.empty();

    if (equipos.length > 0) {
        equipos.forEach(equipo => {
            tbody.append(`
            <tr>
                <td>${equipo.descripcion}</td>
                <td>${equipo.nro_serie}</td>
                <td>${equipo.estado}</td>
                <td>
                    <div class="action-buttons">
                        <a href="/equipos/${equipo.id}" class="btn btn-detalles btn-sm">
                            <i class="fas fa-info-circle"></i> Detalles
                        </a>
                        <a href="/equipos/${equipo.id}/edit" class="btn btn-editar btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-eliminar btn-sm" onclick="confirmDelete(${equipo.id})">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
        `);
        });
    } else {
        tbody.append('<tr><td colspan="4">No se encontraron equipos.</td></tr>');
    }
}

// Función para limpiar los filtros
function clearFilters() {
    $('#empresa_id, #modalidad_id, #local_id, #estado').val('');
    applyFilters();
}

// Función para confirmar la eliminación
function confirmDelete(equipoId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/equipos/${equipoId}`;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}


    </script>



@endpush