<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('panel') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">IMAP S.A. <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('panel') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Módulos
    </div>

    <!-- Nav Item - Mantenimientos y Calendario -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mantenimientos.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Mantenimientos</span>
        </a>
        <a class="nav-link" href="{{ route('calendar.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Calendario</span>
        </a>
    </li>

    <!-- Sección solo visible para administradores -->
    @if (Auth::user()->hasRole('Administrador'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tecnicos.index') }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Técnicos</span>
            </a>
        </li>
    @endif

    <!-- Usuarios (solo para administradores) -->
    @if (Auth::user()->hasRole('Administrador'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users"></i>
                <span>Usuarios</span>
            </a>
        </li>
    @endif

    <!-- Recursos -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseResources"
            aria-expanded="true" aria-controls="collapseResources">
            <i class="fas fa-boxes mr-2"></i>
            <span>Recursos</span>
        </a>
        <div id="collapseResources" class="collapse" aria-labelledby="headingResources" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestiones</h6>
                <a class="collapse-item" href="{{ route('equipos.index') }}">
                    <i class="fas fa-desktop mr-3"></i><span>Equipos</span>
                </a>
                <a class="collapse-item" href="{{ route('repuestos.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Repuestos</span>
                </a>
                <a class="collapse-item" href="{{ route('modalidades.index') }}">
                    <i class="fas fa-clipboard-list mr-3"></i><span>Modalidades</span>
                </a>
                <a class="collapse-item" href="{{ route('componentes.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Componentes</span>
                </a>
                <a class="collapse-item" href="{{ route('subcomponentes.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Sub Componentes</span>
                </a>
            </div>
        </div>
    </li>

    <!-- Utilidades -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-tools mr-2"></i>
            <span>Utilidades</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestiones</h6>
                <a class="collapse-item" href="{{ route('locals.index') }}">
                    <i class="fas fa-map-marker-alt mr-3"></i><span>Locales</span>
                </a>
                <a class="collapse-item" href="{{ route('empresas.index') }}">
                    <i class="fas fa-building mr-3"></i><span>Empresas</span>
                </a>
                <a class="collapse-item" href="{{ route('departamentos.index') }}">
                    <i class="fas fa-sitemap mr-3"></i><span>Departamentos</span>
                </a>
                <a class="collapse-item" href="{{ route('subdepartamentos.index') }}">
                    <i class="fas fa-project-diagram mr-3"></i><span>SubDepartamentos</span>
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
