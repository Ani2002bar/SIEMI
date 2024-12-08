@extends('template')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h3>Perfil de Usuario</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: {{ Auth::user()->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="card-text"><strong>Rol:</strong> 
                @foreach (Auth::user()->getRoleNames() as $role)
                    <span class="badge badge-primary">{{ $role }}</span>
                @endforeach
            </p>
            <p class="card-text"><strong>Fecha de Registro:</strong> {{ Auth::user()->created_at->format('d-m-Y') }}</p>
        </div>
    </div>
</div>
@endsection
