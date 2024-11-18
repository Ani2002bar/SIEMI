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

<div class="mb-4">
    <a href="{{ route('equipos.create') }}">
        <button type="button" class="btn btn-primary">Añadir nuevo equipo</button>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="filter-container">
            <div class="form-group">
                <label for="empresa_id">Empresa</label>
                <select name="empresa_id" id="empresa_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ request('empresa_id') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="modalidad_id">Modalidad</label>
                <select name="modalidad_id" id="modalidad_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->id }}" {{ request('modalidad_id') == $modalidad->id ? 'selected' : '' }}>
                            {{ $modalidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="local_id">Local</label>
                <select name="local_id" id="local_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->id }}" {{ request('local_id') == $local->id ? 'selected' : '' }}>
                            {{ $local->nombre_local }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="departamento_id">Departamento</label>
                <select name="departamento_id" id="departamento_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subdepartamento_id">Subdepartamento</label>
                <select name="subdepartamento_id" id="subdepartamento_id" class="form-control form-control-sm">
                    <option value="">Todos</option>
                </select>
            </div>
            <button type="button" id="clearFiltersButton">Eliminar filtros</button>
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
                                <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-info-circle"></i> Detalles
                                </a>
                                <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $equipo->id }})">
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

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                ¿Seguro que quieres eliminar este equipo?
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });

            loadFiltersFromSession();

            $('#empresa_id, #modalidad_id, #local_id, #departamento_id, #subdepartamento_id').on('change', filterData);
            $('#clearFiltersButton').on('click', clearFilters);

            $('#local_id').on('change', function() {
                loadDepartamentos($(this).val());
                $('#subdepartamento_id').html('<option value="">Todos</option>');
            });

            $('#departamento_id').on('change', function() {
                loadSubdepartamentos($(this).val());
            });
        });

        function loadFiltersFromSession() {
            ['empresa_id', 'modalidad_id', 'local_id', 'departamento_id', 'subdepartamento_id'].forEach(id => {
                if (sessionStorage.getItem(id)) {
                    $(`#${id}`).val(sessionStorage.getItem(id));
                }
            });

            if ($('#local_id').val()) loadDepartamentos($('#local_id').val());
            if ($('#departamento_id').val()) loadSubdepartamentos($('#departamento_id').val());
        }

        function loadDepartamentos(localId) {
            const departamentoSelect = $('#departamento_id');
            departamentoSelect.html('<option value="">Cargando...</option>');
            if (localId) {
                $.get(`/api/departamentos/${localId}`, function(data) {
                    let options = '<option value="">Todos</option>';
                    data.forEach(depto => options += `<option value="${depto.id}">${depto.nombre}</option>`);
                    departamentoSelect.html(options);
                    if (sessionStorage.getItem('departamento_id')) {
                        departamentoSelect.val(sessionStorage.getItem('departamento_id'));
                    }
                });
            } else {
                departamentoSelect.html('<option value="">Todos</option>');
            }
        }

        function loadSubdepartamentos(departamentoId) {
            const subdepartamentoSelect = $('#subdepartamento_id');
            subdepartamentoSelect.html('<option value="">Cargando...</option>');
            if (departamentoId) {
                $.get(`/api/subdepartamentos/${departamentoId}`, function(data) {
                    let options = '<option value="">Todos</option>';
                    data.forEach(subdepto => options += `<option value="${subdepto.id}">${subdepto.nombre}</option>`);
                    subdepartamentoSelect.html(options);
                    if (sessionStorage.getItem('subdepartamento_id')) {
                        subdepartamentoSelect.val(sessionStorage.getItem('subdepartamento_id'));
                    }
                });
            } else {
                subdepartamentoSelect.html('<option value="">Todos</option>');
            }
        }

        function filterData() {
            const params = {
                empresa_id: $('#empresa_id').val(),
                modalidad_id: $('#modalidad_id').val(),
                local_id: $('#local_id').val(),
                departamento_id: $('#departamento_id').val(),
                subdepartamento_id: $('#subdepartamento_id').val()
            };

            Object.keys(params).forEach(id => {
                sessionStorage.setItem(id, params[id]);
            });

            window.location.href = `{{ route('equipos.index') }}?` + new URLSearchParams(params).toString();
        }

        function clearFilters() {
            sessionStorage.clear();
            $('#empresa_id, #modalidad_id, #local_id, #departamento_id, #subdepartamento_id').val('');
            window.location.href = `{{ route('equipos.index') }}`;
        }

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/equipos/${id}`;
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
