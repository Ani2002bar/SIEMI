<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\SubDepartamentoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\SubComponenteController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Models\Equipo;
use App\Models\Mantenimiento;


// Página de error 404
Route::get('/404', function () {
    return view('pages.404');
});

// Página de inicio
Route::get('/', function () {
    return redirect()->route('login.index'); // Redirigir al login
});

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Agrupación de rutas autenticadas
Route::middleware('auth')->group(function () {
    // Home redirige al panel principal
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    // Perfil del usuario autenticado
    Route::get('/profile', function () {
        return view('components.profile');
    })->name('profile');

    // Panel general

    Route::get('/panel', function () {
        $totalEquipos = Equipo::count();
        $equiposInactivos = Equipo::where('estado', 'Inactivo')->count();
        $mantenimientosPendientes = Mantenimiento::where('estado', 'Pendiente')->count();
        $mantenimientosPendientesList = Mantenimiento::where('estado', 'Pendiente')->take(5)->get();
    
        return view('panel.index', compact(
            'totalEquipos',
            'equiposInactivos',
            'mantenimientosPendientes',
            'mantenimientosPendientesList'
        ));
    })->name('panel');
    
    
    
    
    // Rutas exclusivas para Administradores
    Route::middleware('role:Administrador')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::resource('tecnicos', TecnicoController::class); // Técnicos solo para Administradores
    });

    // Rutas generales para Administradores y Usuarios
    Route::middleware(['role_or_permission:Administrador|Usuario'])->group(function () {
        Route::get('/equipos/pdf', [EquipoController::class, 'generatePdf'])->name('equipos.pdf');
        Route::resource('equipos', EquipoController::class);
        Route::resource('mantenimientos', MantenimientoController::class);
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard.index');
    });

    // Recursos generales
    Route::resource('modalidades', ModalidadController::class);
    Route::resource('locals', LocalController::class);
    Route::resource('empresas', EmpresaController::class);



    Route::resource('repuestos', RepuestoController::class);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('subdepartamentos', SubDepartamentoController::class);
    Route::resource('componentes', ComponenteController::class);
    Route::resource('subcomponentes', SubComponenteController::class);

    // API para cargar datos dinámicamente
    Route::post('/api/departamentos', [DepartamentoController::class, 'store'])->name('api.departamentos.store');
    Route::post('/api/subdepartamentos', [SubDepartamentoController::class, 'store'])->name('api.subdepartamentos.store');
    Route::get('/api/subdepartamentos/{departamentoId}', [SubDepartamentoController::class, 'getSubdepartamentos'])->name('api.subdepartamentos.get');
    Route::get('/api/departamentos/{localId}', [DepartamentoController::class, 'getDepartamentos'])->name('api.departamentos.local');
    Route::post('/api/empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::delete('/api/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    Route::get('/api/empresas', [EmpresaController::class, 'getExistingEmpresas'])->name('api.empresas.get');
    Route::get('api/locals/get', [EmpresaController::class, 'getExistingLocales'])->name('api.locals.get');
    Route::get('/locales/{local}/empresas', [LocalController::class, 'getEmpresas']);

    // Funcionalidades específicas de mantenimiento
    Route::get('/mantenimientos/calendario', [MantenimientoController::class, 'calendar'])->name('mantenimientos.calendario');
    Route::get('/mantenimientos/calendar', [MantenimientoController::class, 'calendar'])->name('mantenimientos.calendar');
    Route::get('/calendar', [MantenimientoController::class, 'calendar'])->name('calendar.index');
    Route::get('/mantenimientos/pdf/{id}', [MantenimientoController::class, 'generatePdf'])->name('mantenimientos.pdf');

    // Repuestos: API y gestión
    Route::get('/api/mantenimientos/repuestos', [MantenimientoController::class, 'getRepuestos'])->name('api.mantenimientos.repuestos.get');
    Route::post('/repuestos', [MantenimientoController::class, 'storeRepuesto'])->name('api.mantenimientos.repuestos.store');

    Route::delete('/api/repuestos/{repuesto}', [MantenimientoController::class, 'destroyRepuesto'])->name('api.repuestos.destroy');
    Route::post('/api/mantenimientos/repuestos/filtered', [RepuestoController::class, 'getFilteredRepuestos'])->name('api.mantenimientos.repuestos.filtered');

    // Rutas para componentes y subcomponentes
    Route::post('/api/componentes', [ComponenteController::class, 'storeFromModal'])->name('api.componentes.store');
    Route::get('/equipos/{equipoId}/componentes', [EquipoController::class, 'getComponentes'])->name('equipos.getComponentes');
    Route::post('/api/subcomponentes', [SubComponenteController::class, 'storeFromModal'])->name('api.subcomponentes.store');
    Route::get('/api/subcomponentes/{componenteId}', [SubComponenteController::class, 'getByComponente'])->name('api.subcomponentes.getByComponente');

    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
    
});
