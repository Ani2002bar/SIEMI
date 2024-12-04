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
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modalidad_id">Modalidad</label>
                        <select name="modalidad_id" id="modalidad_id" class="form-control">
                            <option value="">Todas</option>
                            @foreach($modalidades as $modalidad)
                                <option value="{{ $modalidad->id }}">{{ $modalidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="local_id">Local</label>
                        <select name="local_id" id="local_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}">{{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departamento_id">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="form-control">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subdepartamento_id">Subdepartamento</label>
                        <select name="subdepartamento_id" id="subdepartamento_id" class="form-control">
                            <option value="">Todos</option>
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
