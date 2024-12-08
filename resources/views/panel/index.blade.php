@extends('template')

@section('title', 'Panel')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
        <!-- Botón Generar Reporte -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtrosModal">
            <i class="fas fa-file-pdf"></i> Generar Reporte
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Equipos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Equipos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEquipos ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipos Inactivos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Equipos Inactivos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $equiposInactivos ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mantenimientos Pendientes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Mantenimientos Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mantenimientosPendientes ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row: Estado de Equipos y Mantenimientos Pendientes -->
    <div class="row">
        <!-- Estado de Equipos -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de Equipos</h6>
                </div>
                <div class="card-body">
                    <canvas id="equiposEstadoChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Mantenimientos Pendientes -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Mantenimientos Pendientes</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ítem</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Equipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mantenimientosPendientesList ?? [] as $index => $mantenimiento)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mantenimiento->fecha }}</td>
                                <td>{{ $mantenimiento->estado }}</td>
                                <td>{{ $mantenimiento->equipo->descripcion ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay mantenimientos pendientes.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Filtros -->
<div class="modal fade" id="filtrosModal" tabindex="-1" role="dialog" aria-labelledby="filtrosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filtrosModalLabel">Filtrar Equipos para Generar Informe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="filtrosForm" action="{{ route('equipos.pdf') }}" method="GET" target="_blank">
                    <div class="form-group">
                        <label for="empresa_id">Empresa</label>
                        <select name="empresa_id" id="empresa_id" class="form-control">
                            <option value="">Todas</option>
                            @foreach($empresas ?? [] as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modalidad_id">Modalidad</label>
                        <select name="modalidad_id" id="modalidad_id" class="form-control">
                            <option value="">Todas</option>
                            @foreach($modalidades ?? [] as $modalidad)
                                <option value="{{ $modalidad->id }}">{{ $modalidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="local_id">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach($locals ?? [] as $local)
                                <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">Todos</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const ctx = document.getElementById('equiposEstadoChart').getContext('2d');
    const equiposEstadoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Activos', 'Inactivos'],
            datasets: [{
                label: 'Cantidad de Equipos',
                data: [{{ ($totalEquipos ?? 0) - ($equiposInactivos ?? 0) }}, {{ $equiposInactivos ?? 0 }}],
                backgroundColor: ['#4e73df', '#e74a3b'],
                borderColor: ['#4e73df', '#e74a3b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
