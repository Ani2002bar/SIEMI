@extends('template')

@section('title', 'Repuestos')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        .table-responsive {
            padding-top: 20px;
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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Repuestos</h1>
</div>

<div class="mb-4">
    <a href="{{ route('repuestos.create') }}">
        <button type="button" class="btn btn-primary">Añadir nuevo repuesto</button>
    </a>
</div>

<div class="card shadow mb-4">
   
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       
                        <th>Descripción</th>
                        <th>Observaciones</th>
                        <th>Costo</th>
                        <th>Equipo Asociado</th>
                        <th>Local Asociado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repuestos as $repuesto)
                        <tr>
                           
                            <td>{{ $repuesto->descripcion }}</td>
                            <td>{{ $repuesto->observaciones }}</td>
                            <td>{{ number_format($repuesto->costo, 2) }}</td>
                            <td>
                                @foreach ($repuesto->equipos as $equipo)
                                    {{ $equipo->descripcion }}
                                @endforeach
                            </td>
                            <td>{{ $repuesto->local->nombre_local ?? 'N/A' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <!-- Botón Detalles -->
                                    <a href="{{ route('repuestos.show', $repuesto->id) }}" class="btn btn-detalles btn-sm">
                                        <i class="fas fa-info-circle"></i> Detalles
                                    </a>
                                    <!-- Botón Editar -->
                                    <a href="{{ route('repuestos.edit', $repuesto->id) }}" class="btn btn-editar btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <!-- Botón Eliminar con Modal -->
                                    <button type="button" class="btn btn-eliminar btn-sm" onclick="confirmDelete({{ $repuesto->id }})">
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                ¿Seguro que quieres eliminar este repuesto?
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
            form.action = `/repuestos/${id}`;
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
