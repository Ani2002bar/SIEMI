@extends('template')

@section('title', 'Subdepartamentos')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Ajuste de botones en la tabla de acciones */
        .action-buttons {
            display: flex;
            justify-content: space-around; /* Espacio entre los botones */
            align-items: center;
        }
        .action-buttons .btn {
            border-radius: 5px; /* Bordes redondeados */
            padding: 6px 12px; /* Ajuste de tamaño */
            margin: 0 3px; /* Espacio entre botones */
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
    <h1 class="h3 mb-0 text-gray-800">Subdepartamentos</h1>
</div>
<div class="mb-4">
    <a href="{{ route('subdepartamentos.create') }}">
        <button type="button" class="btn btn-primary">Añadir nuevo subdepartamento</button>
    </a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Subdepartamentos</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($subdepartamentos as $subdepartamento)
                    <tr>
                        <td>{{ $subdepartamento->nombre }}</td>
                        <td>{{ $subdepartamento->descripcion }}</td>
                        <td>{{ $subdepartamento->departamento->nombre }}</td>
                        <td>
                            <div class="action-buttons">
                                <!-- Botón Detalles -->
                                <a href="{{ route('subdepartamentos.show', $subdepartamento->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-info-circle"></i> Detalles
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('subdepartamentos.edit', $subdepartamento->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Botón Eliminar con Modal -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $subdepartamento->id }})">
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

<!-- Modal de confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                ¿Seguro que quieres eliminar este subdepartamento?
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
        $(document).ready(function() {
            var pageLength = localStorage.getItem('datatable_pageLength') || 10;

            var table = $('#dataTable').DataTable({
                "pageLength": parseInt(pageLength),
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

            table.on('length.dt', function(e, settings, len) {
                localStorage.setItem('datatable_pageLength', len);
            });
        });

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/subdepartamentos/${id}`;
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
