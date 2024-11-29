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

// Página de error 404
Route::get('/404', function () {
    return view('pages.404');
});

// Página de inicio (template base)
Route::get('/', function () {
    return view('template');
});

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

// Rutas protegidas para roles específicos
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});

// Rutas protegidas por permisos
Route::middleware(['auth', 'permission:ver reportes'])->group(function () {
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});

// Rutas accesibles con rol o permiso específico
Route::middleware(['auth', 'role_or_permission:Manager|edit reports'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
});

// Home redirige al panel.index
Route::get('/home', [HomeController::class, 'index'])->name('home.index')->middleware('auth');

// Panel general
Route::get('/panel', function () {
    return view('panel.index');
})->name('panel');

// Recursos generales
Route::resource('modalidades', ModalidadController::class);
Route::resource('locals', LocalController::class);
Route::resource('empresas', EmpresaController::class);
Route::resource('equipos', EquipoController::class);
Route::resource('repuestos', RepuestoController::class);
Route::resource('mantenimientos', MantenimientoController::class);
Route::resource('departamentos', DepartamentoController::class);
Route::resource('subdepartamentos', SubDepartamentoController::class);
Route::resource('componentes', ComponenteController::class);
Route::resource('subcomponentes', SubComponenteController::class);
Route::resource('tecnicos', TecnicoController::class);

// API para cargar departamentos y subdepartamentos dinámicamente
Route::post('/api/departamentos', [DepartamentoController::class, 'store'])->name('api.departamentos.store');
Route::post('/api/subdepartamentos', [SubDepartamentoController::class, 'store'])->name('api.subdepartamentos.store');
Route::get('/api/subdepartamentos/{departamentoId}', [SubDepartamentoController::class, 'getSubdepartamentos'])->name('api.subdepartamentos.get');

// API para cargar departamentos por local
Route::get('/api/departamentos/{localId}', [DepartamentoController::class, 'getDepartamentos'])->name('api.departamentos.local');

Route::post('/api/empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
Route::delete('/api/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
Route::get('/api/empresas', [EmpresaController::class, 'getExistingEmpresas'])->name('api.empresas.get');