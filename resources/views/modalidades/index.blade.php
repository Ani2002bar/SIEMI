@extends('template')

@section('title','Modalidades')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <h1 class="h3 mb-0 text-gray-800">Modalidades</h1>
</div>
<div class="mb-4">
    <a href="{{ route('modalidades.create') }}">
        <button type="button" class="btn btn-primary">Añadir nueva modalidad</button>
    </a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Modalidades</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped fs-6" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($modalidades as $modalidad)
                    <tr>
                        <td>{{ $modalidad->nombre }}</td>
                        <td>{{ $modalidad->descripcion }}</td>
                        <td>
                            @if ($modalidad->estado == 1)
                                <span class="badge rounded-pill text-bg-success">Activo</span>
                            @else
                                <span class="badge rounded-pill text-bg-danger">Eliminado</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <!-- Botón Editar -->
                                <a href="{{ route('modalidades.edit', $modalidad->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Separador -->
                                <div class="vr"></div>

                                <!-- Botón Eliminar con Modal -->
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $modalidad->id }})">
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Seguro que quieres eliminar esta modalidad?
            </div>
            <div class="modal-footer">
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
            // Obtener la cantidad de registros seleccionada previamente de localStorage
            var pageLength = localStorage.getItem('datatable_pageLength') || 10;

            // Inicializar DataTable con la configuración para seleccionar cantidad de registros
            var table = $('#dataTable').DataTable({
                "pageLength": parseInt(pageLength), // Usa el valor guardado en localStorage o el valor predeterminado de 10
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

            // Guardar la cantidad de registros seleccionada en localStorage cada vez que cambie
            table.on('length.dt', function(e, settings, len) {
                localStorage.setItem('datatable_pageLength', len);
            });
        });

        // Función para configurar la acción de eliminación y mostrar el modal
        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/modalidades/${id}`; // Actualiza la acción del formulario
            $('#deleteModal').modal('show'); // Muestra el modal
        }
    </script>
@endpush
