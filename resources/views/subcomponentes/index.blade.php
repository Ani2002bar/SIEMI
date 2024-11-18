@extends('template')

@section('title', 'Subcomponentes')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        /* Ajuste de botones en la tabla de acciones */
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
        /* Contenedor y estilo de tabla */
        .table-responsive {
            margin-top: 20px;
        }
        .page-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-top: 10px;
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
    <h1 class="h3 mb-0 text-gray-800">Subcomponentes</h1>
</div>

<div class="mb-4">
    <a href="{{ route('subcomponentes.create') }}">
        <button type="button" class="btn btn-primary">Añadir nuevo subcomponente</button>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Subcomponentes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Modelo</th>
                        <th>Número de Serie</th>
                        <th>Componente Asociado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($subcomponentes as $subcomponente)
                    <tr>
                        <td>{{ $subcomponente->descripcion }}</td>
                        <td>{{ $subcomponente->modelo }}</td>
                        <td>{{ $subcomponente->nro_serie }}</td>
                        <td>{{ $subcomponente->componente->descripcion }}</td>
                        <td>
                            <div class="action-buttons">
                                <!-- Botón Detalles -->
                                <a href="{{ route('subcomponentes.show', $subcomponente->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-info-circle"></i> Detalles
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('subcomponentes.edit', $subcomponente->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Botón Eliminar con Modal -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $subcomponente->id }})">
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
                ¿Seguro que quieres eliminar este subcomponente?
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
    <!-- DataTables JavaScript -->
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
        });

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/subcomponentes/${id}`;
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
