@extends('template')

@section('title', 'Lista de Técnicos')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Lista de Técnicos</h1>
    <a href="{{ route('tecnicos.create') }}" class="btn btn-primary mb-3">Añadir Técnico</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tecnicos as $tecnico)
                <tr>
                    <td>{{ $tecnico->nombre }}</td>
                    <td>{{ $tecnico->apellido }}</td>
                    <td>{{ $tecnico->correo }}</td>
                    <td>{{ $tecnico->telefono }}</td>
                    <td>
                        <a href="{{ route('tecnicos.edit', $tecnico->id) }}" class="btn btn-info btn-sm">Editar</a>
                        <form action="{{ route('tecnicos.destroy', $tecnico->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este técnico?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
