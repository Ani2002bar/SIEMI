@extends('template')

@section('title', 'Empresas')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Bootstrap 4 CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

    <style>
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
    <h1 class="h3 mb-0 text-gray-800">Empresas</h1>
</div>
<div class="mb-4">
    <a href="{{ route('empresas.create') }}">
        <button type="button" class="btn btn-primary">Añadir nueva empresa</button>
    </a>
</div>
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nombre }}</td>
                            <td>{{ $empresa->direccion }}</td>
                            <td>{{ $empresa->telefono }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <!-- Botón Detalles -->
                                    <a href="{{ route('empresas.show', $empresa->id) }}" class="btn-detalles">
                                        <i class="fas fa-info-circle"></i> Detalles
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn-editar">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>

                                    <!-- Botón Eliminar con Modal -->
                                    <button type="button" class="btn-eliminar" onclick="confirmDelete({{ $empresa->id }})">
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
<!-- Modal de confirmación para eliminar repuesto -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                ¿Seguro que quieres eliminar este repuesto?
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

            table.on('length.dt', function (e, settings, len) {
                localStorage.setItem('datatable_pageLength', len);
            });
        });

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/empresas/${id}`;
            $('#deleteModal').modal('show');
        }
    </script>
@endpush