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
            <span>Panel</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading 
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu 
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="{{ asset('vendor/startbootstrap-sb-admin-2/buttons.html') }}">Buttons</a>
<a class="collapse-item" href="{{ asset('vendor/startbootstrap-sb-admin-2/cards.html') }}">Cards</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Modulos
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    <li class="nav-item">
        <a class="nav-link" href="{{ route('mantenimientos.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Mantenimientos</span></a>
            <a class="nav-link" href="{{ route('calendar.index') }}">
    <i class="fas fa-calendar-alt"></i>
    <span>Calendario</span>
</a>
        <a class="nav-link" href="{{ route('tecnicos.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Tecnicos</span></a>
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Usuarios</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseResources"
            aria-expanded="true" aria-controls="collapseResources">
            <i class="fas fa-boxes mr-2"></i>
            <span>Recursos</span>
        </a>
        <div id="collapseResources" class="collapse" aria-labelledby="headingResources" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestiones</h6>
                <a class="collapse-item d-flex align-items-center" href="{{ route('equipos.index') }}">
                    <i class="fas fa-desktop mr-3"></i><span>Equipos</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('repuestos.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Repuestos</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('modalidades.index') }}">
                    <i class="fas fa-clipboard-list mr-3"></i><span>Modalidades</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('componentes.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Componentes</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('subcomponentes.index') }}">
                    <i class="fas fa-cogs mr-3"></i><span>Sub Componentes</span>
                </a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-tools mr-2"></i>
            <span>Utilidades</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestiones</h6>

                <a class="collapse-item d-flex align-items-center" href="{{ route('locals.index') }}">
                    <i class="fas fa-map-marker-alt mr-3"></i><span>Locales</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('empresas.index') }}">
                    <i class="fas fa-building mr-3"></i><span>Empresas</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('departamentos.index') }}">
                    <i class="fas fa-sitemap mr-3"></i><span>Departamentos</span>
                </a>
                <a class="collapse-item d-flex align-items-center" href="{{ route('subdepartamentos.index') }}">
                    <i class="fas fa-project-diagram mr-3"></i><span>SubDepartamentos</span>
                </a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>




    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="{{ route('login.index') }}">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->


    <!-- Nav Item - Tables -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SIEMI</strong> </p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div>


</ul>
<!-- End of Sidebar -->